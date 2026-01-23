from playwright.sync_api import sync_playwright, expect
import time

def test_admin_features():
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
            # 1. Test Curriculum Manager
            # ----------------------------------------------------------------
            print("Testing Curriculum Manager...")
            page.goto("http://127.0.0.1:8000/admin/curriculum")

            # Check Header
            expect(page.locator("header").get_by_text("Curriculum Manager")).to_be_visible()

            # Check Table
            expect(page.get_by_text("Subject Management")).to_be_visible()
            expect(page.get_by_text("MATH7")).to_be_visible()

            # Open Add Subject Modal
            page.click("button:has-text('Add Subject')")
            expect(page.get_by_text("Add New Subject")).to_be_visible()

            # Fill Form
            page.fill("input#code", "AP8")
            page.fill("input#name", "Araling Panlipunan 8")
            page.select_option("select#grade_level", value="8")

            # Small delay
            page.wait_for_timeout(1000)

            # Save
            print("Clicking Save...")
            page.click("button:has-text('Save')")
            page.wait_for_timeout(1000) # Wait for network/processing

            # Debug: Check if modal is closed
            if page.locator("text=Add New Subject").is_visible():
                print("DEBUG: Modal appears to still be open.")
            else:
                print("DEBUG: Modal is closed.")

            # Debug: Dump content
            with open("verification/debug_curriculum.html", "w") as f:
                f.write(page.content())

            # Verify new entry in table
            expect(page.get_by_text("AP8")).to_be_visible()
            expect(page.get_by_text("Araling Panlipunan 8")).to_be_visible()

            print("Curriculum Manager verified.")

            # ----------------------------------------------------------------
            # 2. Test Section Manager
            # ----------------------------------------------------------------
            print("Testing Section Manager...")
            page.goto("http://127.0.0.1:8000/admin/sections")

            # Check Header
            expect(page.locator("header").get_by_text("Section Manager")).to_be_visible()

            # Check Table
            expect(page.get_by_text("Section Management")).to_be_visible()
            expect(page.get_by_text("Rizal")).to_be_visible()

            # Open Create Section Modal
            page.click("button:has-text('Create Section')")
            expect(page.get_by_text("Create New Section")).to_be_visible()

            # Fill Form
            page.fill("input#name", "Narra")
            page.select_option("select#grade_level", value="7")
            page.select_option("select#adviser", value="Ms. Maria Santos")

            # Small delay
            page.wait_for_timeout(1000)

            # Save
            page.click("button:has-text('Save')")
            page.wait_for_timeout(1000)

            # Verify new entry
            expect(page.get_by_text("Narra")).to_be_visible()

            print("Section Manager verified.")

            print("All Admin Features Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_admin_features.png")
            print("Captured error_admin_features.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_admin_features()
