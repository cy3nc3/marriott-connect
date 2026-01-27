from playwright.sync_api import sync_playwright, expect

def test_part_m():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(viewport={"width": 1280, "height": 800})
        page = context.new_page()

        try:
            # Login
            print("Navigating to login...")
            page.goto("http://127.0.0.1:8000/login")
            page.fill("input[name='email']", "test@example.com")
            page.fill("input[name='password']", "password")
            page.click("button:has-text('Log in')")
            page.wait_for_url("**/dashboard")
            print("Logged in.")

            # ----------------------------------------------------------------
            # 1. Test Remedial Page Load
            # ----------------------------------------------------------------
            print("Testing Remedial Page...")
            page.goto("http://127.0.0.1:8000/registrar/remedial")

            # Check Header
            expect(page.get_by_text("Remedial / Summer Class Entry")).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Test Search & Select
            # ----------------------------------------------------------------
            print("Testing Search...")
            page.fill("input[placeholder='Search Retained Student...']", "Dizon")

            # Wait for dropdown
            expect(page.get_by_text("Dizon, Pedro")).to_be_visible()

            # Select
            page.click("button:has-text('Dizon, Pedro')")

            # Check Selection Card
            expect(page.get_by_text("Failed Subject")).to_be_visible()
            expect(page.get_by_text("Mathematics 7")).to_be_visible()
            expect(page.get_by_text("70")).to_be_visible() # Old Grade

            # ----------------------------------------------------------------
            # 3. Test Calculation Logic
            # ----------------------------------------------------------------
            print("Testing Calculation...")

            # Enter Remedial Grade: 80
            # Formula: (70 + 80) / 2 = 75
            page.fill("input[placeholder='e.g. 80']", "80")

            # Wait for Recomputed
            # The calculation might take a roundtrip or be instant if alpine, but here it is livewire.
            expect(page.get_by_text("New Final Grade:")).to_be_visible()
            expect(page.get_by_text("75.00")).to_be_visible()
            expect(page.get_by_text("Result: Passed")).to_be_visible()

            # ----------------------------------------------------------------
            # 4. Test Update Action
            # ----------------------------------------------------------------
            print("Testing Update Action...")

            # Click Update
            page.click("button:has-text('Update Status to Promoted')")

            # Check Flash
            expect(page.get_by_text("updated to Promoted")).to_be_visible()

            # Screenshot success
            page.screenshot(path="verification/part_m_success.png")
            print("Remedial Entry verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_m.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_m()
