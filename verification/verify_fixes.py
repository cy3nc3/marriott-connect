from playwright.sync_api import sync_playwright, expect

def test_fixes():
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
            # 1. Test Super Admin School Year Route
            # ----------------------------------------------------------------
            print("Testing Super Admin School Year Route...")
            page.goto("http://127.0.0.1:8000/admin/school-year")

            # Should show School Year Manager (Active Operations)
            expect(page.get_by_text("School Year Manager")).to_be_visible()
            expect(page.get_by_text("Active Operations")).to_be_visible()

            print("Super Admin School Year Route verified.")

            # ----------------------------------------------------------------
            # 2. Test Student Schedule Route
            # ----------------------------------------------------------------
            print("Testing Student Schedule Route...")
            page.goto("http://127.0.0.1:8000/student/schedule")

            expect(page.locator("header").get_by_text("My Schedule")).to_be_visible()
            expect(page.get_by_text("Daily Schedule")).to_be_visible()
            expect(page.get_by_text("Mathematics")).to_be_visible()
            expect(page.get_by_text("Mr. Cruz")).to_be_visible()

            print("Student Schedule Route verified.")

            # ----------------------------------------------------------------
            # 3. Test Student Grades Route
            # ----------------------------------------------------------------
            print("Testing Student Grades Route...")
            page.goto("http://127.0.0.1:8000/student/grades")

            expect(page.locator("header").get_by_text("Report Card")).to_be_visible()
            expect(page.get_by_text("Progress Report")).to_be_visible()
            expect(page.get_by_text("Science")).to_be_visible()
            expect(page.get_by_text("92")).to_be_visible()

            print("Student Grades Route verified.")

            print("All Fixes Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_fixes.png")
            print("Captured error_fixes.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_fixes()
