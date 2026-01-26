from playwright.sync_api import sync_playwright, expect

def test_part_g():
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
            # 1. Test Discount Manager Page
            # ----------------------------------------------------------------
            print("Testing Discount Manager...")
            page.goto("http://127.0.0.1:8000/finance/discounts")

            # Check Header
            expect(page.locator("header").get_by_text("Scholarship & Discounts")).to_be_visible()

            # Check Sections
            expect(page.get_by_text("Discount Types")).to_be_visible()
            expect(page.get_by_text("Scholar List")).to_be_visible()

            # Check Mock Data
            expect(page.get_by_text("Sibling Discount").first).to_be_visible()
            expect(page.get_by_text("Ana Lee")).to_be_visible()
            expect(page.get_by_text("3,000.00")).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Test Create Discount Modal
            # ----------------------------------------------------------------
            print("Testing Create Discount Modal...")
            # Click the plus button (using title or icon if possible, or class)
            page.click("button[title='Create Discount']")

            # Check Modal
            expect(page.get_by_text("Create New Discount")).to_be_visible()

            # Fill Form
            page.fill("input[placeholder='e.g. Loyalty Award']", "Loyalty Award")
            page.fill("input[type='number']", "5")

            # Save
            page.click("button:has-text('Create')")

            # Verify new entry
            expect(page.get_by_text("Discount type created.")).to_be_visible()
            # Use first just in case, or scope to the list
            expect(page.locator("h4").get_by_text("Loyalty Award")).to_be_visible()

            print("Create Discount Modal verified.")

            # ----------------------------------------------------------------
            # 3. Test Tag Student Modal
            # ----------------------------------------------------------------
            print("Testing Tag Student Modal...")
            page.click("button:has-text('Tag Student')")

            # Check Modal
            # Scope to header
            expect(page.locator("h3:has-text('Tag Student')")).to_be_visible()

            # Fill Form
            page.fill("input[placeholder='Search student...']", "New Student")
            # Target the specific select for the tag modal
            page.select_option("select[wire\\:model='tagDiscountId']", index=1)

            # Tag
            # Use specific wire:click selector to avoid ambiguity with the "Tag Student" button
            page.click("button[wire\\:click='tagStudent']")

            # Verify new entry
            expect(page.get_by_text("Student tagged successfully.")).to_be_visible()
            expect(page.get_by_text("New Student")).to_be_visible()

            print("Tag Student Modal verified.")

            page.screenshot(path="verification/part_g_success.png")
            print("All Part G Features Verified. Screenshot saved to verification/part_g_success.png")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_g.png")
            print("Captured error_part_g.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_g()
