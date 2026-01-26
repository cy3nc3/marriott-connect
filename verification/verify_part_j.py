from playwright.sync_api import sync_playwright, expect
import datetime

def test_part_j():
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
            # 1. Test Daily Remittance Load
            # ----------------------------------------------------------------
            print("Testing Daily Remittance...")
            page.goto("http://127.0.0.1:8000/finance/remittance")

            # Check Header
            expect(page.get_by_text("Daily Collection Report")).to_be_visible()

            # Check Date (Current Date)
            today = datetime.datetime.now().strftime("%B %-d, %Y") # e.g. January 1, 2024
            # Linux usually uses %-d for no-zero-pad day, Windows might need %#d. Python 3 typically handles it.
            # Let's just check for "Daily Collection Report" and maybe year.
            expect(page.get_by_text(datetime.datetime.now().strftime("%Y"))).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Verify Totals
            # ----------------------------------------------------------------
            print("Verifying Totals...")
            # Total Collected: 15k+12k+5k+2.5k+3k+1.5k+6k+1.2k = 46,200
            # Strict mode: It appears in the card and the footer. Check the card specifically.
            expect(page.locator(".text-3xl").get_by_text("46,200.00")).to_be_visible()

            # Cash: 15k + 5k + 3k + 1.5k = 24,500
            expect(page.get_by_text("24,500.00")).to_be_visible()

            # Digital: 12k + 2.5k + 6k + 1.2k = 21,700
            expect(page.get_by_text("21,700.00")).to_be_visible()

            # ----------------------------------------------------------------
            # 3. Verify Breakdown Table
            # ----------------------------------------------------------------
            print("Verifying Breakdown...")
            expect(page.get_by_text("Tuition")).to_be_visible()
            expect(page.get_by_text("Uniforms")).to_be_visible()

            # ----------------------------------------------------------------
            # 4. Verify Print Logic (Static Check)
            # ----------------------------------------------------------------
            print("Verifying Print Button...")
            print_btn = page.locator("button:has-text('Print Z-Reading')")
            expect(print_btn).to_be_visible()

            # Check if print media styles exist in the page content
            # This is a bit indirect, but we can check if a style tag contains @media print
            content = page.content()
            if "@media print" not in content:
                raise Exception("Print styles not found in page content")

            # Screenshot success
            page.screenshot(path="verification/part_j_success.png")
            print("Daily Remittance verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_j.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_j()
