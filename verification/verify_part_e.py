from playwright.sync_api import sync_playwright, expect

def test_part_e():
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
            # 1. Test Permanent Records Page
            # ----------------------------------------------------------------
            print("Testing Permanent Records...")
            page.goto("http://127.0.0.1:8000/registrar/permanent-record")

            # Check Header
            expect(page.locator("header").get_by_text("Permanent Record (SF10)")).to_be_visible()

            # Check Search Bar
            expect(page.get_by_placeholder("Search by name or LRN...")).to_be_visible()

            # Simulate Search
            print("Searching for Student...")
            page.fill("input#studentQuery", "Juan")
            page.click("button:has-text('Search')")

            # Check Selected Student Card
            expect(page.get_by_text("Juan Cruz")).to_be_visible()
            # Scope to avoid conflict with dropdown option "Grade 10"
            expect(page.locator("div.bg-indigo-50").get_by_text("Grade 10")).to_be_visible()
            expect(page.get_by_text("Print SF10")).to_be_visible()

            # Check History Grid
            expect(page.get_by_text("Academic History")).to_be_visible()
            # St. Mary's Academy exists in mock data
            expect(page.get_by_text("St. Mary's Academy").first).to_be_visible()

            # Check Add Form
            expect(page.get_by_text("Add Historical Record")).to_be_visible()

            # Test Adding a Subject Row
            print("Testing Add Subject Row...")
            page.click("button:has-text('Add Subject')")
            page.wait_for_timeout(500)

            # Fill Form (Use blur to trigger update)
            print("Filling New Record...")
            page.fill("input#newSchoolName", "San Jose High")
            page.locator("input#newSchoolName").blur()

            page.fill("input#newSchoolYear", "2021-2022")
            page.locator("input#newSchoolYear").blur()

            # Fill subjects - the first row is always there, assume we fill that
            page.locator("input[placeholder='Subject']").first.fill("Math")
            page.locator("input[placeholder='Subject']").first.blur()

            page.locator("input[placeholder='Grade']").first.fill("90")
            page.locator("input[placeholder='Grade']").first.blur()

            # Save
            print("Saving Record...")
            page.click("button:has-text('Save Record')")

            # Verify Success
            expect(page.get_by_text("Historical record saved successfully.")).to_be_visible()

            # Check if new record appears in list
            expect(page.get_by_text("San Jose High")).to_be_visible()

            print("Permanent Records verified.")

            print("All Part E Features Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_e.png")
            print("Captured error_part_e.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_e()
