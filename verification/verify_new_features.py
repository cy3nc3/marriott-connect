from playwright.sync_api import sync_playwright, expect

def test_new_features():
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
            # 1. Test Teacher Grading Sheet
            # ----------------------------------------------------------------
            print("Testing Teacher Grading Sheet...")
            page.goto("http://127.0.0.1:8000/teacher/grading")

            expect(page.locator("header").get_by_text("Grading Sheet")).to_be_visible()
            expect(page.get_by_text("Quiz 1")).to_be_visible()
            expect(page.get_by_text("Cruz, Juan")).to_be_visible()
            input_box = page.locator("tbody input[type='number']").first
            expect(input_box).to_be_visible()

            print("Teacher Grading Sheet verified.")

            # ----------------------------------------------------------------
            # 2. Test Student Dashboard
            # ----------------------------------------------------------------
            print("Testing Student Dashboard...")
            page.goto("http://127.0.0.1:8000/student/dashboard")
            expect(page.locator("header").get_by_text("My Dashboard")).to_be_visible()

            # Check default tab: Schedule
            schedule_tab = page.locator("div[x-show=\"tab === 'schedule'\"]")
            expect(schedule_tab.get_by_text("Daily Schedule")).to_be_visible()
            # Scope search to the schedule tab
            expect(schedule_tab.get_by_text("Mathematics")).to_be_visible()

            # Switch to Grades Tab
            page.click("button:has-text('Report Card')")

            # Wait for transition and visibility of Grades tab
            grades_tab = page.locator("div[x-show=\"tab === 'grades'\"]")
            expect(grades_tab.get_by_text("Progress Report")).to_be_visible()
            expect(grades_tab.get_by_text("92")).to_be_visible() # English Q1

            print("Student Dashboard verified.")

            # ----------------------------------------------------------------
            # 3. Test Parent Dashboard
            # ----------------------------------------------------------------
            print("Testing Parent Dashboard...")
            page.goto("http://127.0.0.1:8000/parent/dashboard")
            expect(page.locator("header").get_by_text("Parent Portal")).to_be_visible()

            expect(page.get_by_text("Currently Viewing: Juan Cruz")).to_be_visible()
            expect(page.locator("div.border-red-500")).to_contain_text("6,000.00")

            page.select_option("select#childSelect", label="Ana Cruz")

            expect(page.get_by_text("Currently Viewing: Ana Cruz")).to_be_visible()
            expect(page.locator("div.border-red-500")).to_contain_text("2,500.00")

            print("Parent Dashboard verified.")

            page.screenshot(path="verification/new_features.png")
            print("All New Features Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_new_features.png")
            print("Captured error_new_features.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_new_features()
