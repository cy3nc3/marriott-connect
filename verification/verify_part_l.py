from playwright.sync_api import sync_playwright, expect
import datetime

def test_part_l():
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
            # 1. Test Class List Report Load
            # ----------------------------------------------------------------
            print("Testing Class List Report...")
            page.goto("http://127.0.0.1:8000/admin/reports/classlist")

            # Check Header
            expect(page.get_by_text("Official Class List")).to_be_visible()
            expect(page.get_by_text("Marriott Connect School System")).to_be_visible()

            # Check Default Section (Grade 7 - Rizal)
            # Strict mode violation fix: Target the bold span in the subheader, avoiding the select option.
            expect(page.locator(".print-container").get_by_text("Grade 7 - Rizal")).to_be_visible()
            expect(page.get_by_text("Mr. Juan Cruz")).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Verify Lists
            # ----------------------------------------------------------------
            print("Verifying Lists...")

            # Check Boys Column
            expect(page.get_by_text("BOYS").first).to_be_visible()
            expect(page.get_by_text("Abad, Anthony")).to_be_visible()

            # Check Girls Column
            expect(page.get_by_text("GIRLS").first).to_be_visible()
            expect(page.get_by_text("Alonzo, Bea")).to_be_visible()

            # ----------------------------------------------------------------
            # 3. Test Section Switching
            # ----------------------------------------------------------------
            print("Testing Section Switch...")
            page.select_option("select#section-select", "2") # Grade 8

            # Wait for update
            # Scope to container again to avoid select option ambiguity
            expect(page.locator(".print-container").get_by_text("Grade 8 - Bonifacio")).to_be_visible()
            expect(page.get_by_text("Ms. Maria Santos")).to_be_visible()

            # Check new names
            expect(page.get_by_text("Ignacio, Ivan")).to_be_visible()
            expect(page.get_by_text("Imperial, Iza")).to_be_visible()

            # ----------------------------------------------------------------
            # 4. Verify Print Button & CSS
            # ----------------------------------------------------------------
            print("Verifying Print Button...")
            print_btn = page.locator("button:has-text('Print Class List')")
            expect(print_btn).to_be_visible()

            # Check print styles exist
            content = page.content()
            if "@media print" not in content:
                raise Exception("Print styles not found in page content")

            # Screenshot success
            page.screenshot(path="verification/part_l_success.png")
            print("Class List Report verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_l.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_l()
