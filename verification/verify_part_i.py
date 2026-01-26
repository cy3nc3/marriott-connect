from playwright.sync_api import sync_playwright, expect

def test_part_i():
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
            # 1. Test Advisory Board Load
            # ----------------------------------------------------------------
            print("Testing Advisory Board...")
            page.goto("http://127.0.0.1:8000/teacher/advisory")

            # Check Header
            expect(page.get_by_text("Advisory Board")).to_be_visible()
            expect(page.get_by_text("Grade 10 - Rizal")).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Test Tab 1: Grades
            # ----------------------------------------------------------------
            print("Verifying Consolidated Grades...")
            # Default tab should be grades
            # Strict mode violation fix: Scope to the visible table or use first/nth, as Juan appears in both tabs (hidden and visible)
            expect(page.get_by_text("Juan Dela Cruz").first).to_be_visible()

            # Check for grades (e.g. 85, 95)
            expect(page.get_by_text("85").first).to_be_visible()

            # Check for Failing Grade Red Text logic
            # Pedro Penduko has 74 in Math
            failing_grade = page.locator("td:has-text('74')").first
            # Playwright to_have_class needs exact class string or regex.
            # Since Tailwind classes can be ordered differently or have extra spacing, we use regex.
            import re
            expect(failing_grade).to_have_class(re.compile(r"text-red-600"))

            # Check Average Calculation
            # Juan: (85+88+90+92+89)/5 = 88.80
            expect(page.get_by_text("88.80")).to_be_visible()

            # ----------------------------------------------------------------
            # 3. Test Tab 2: Values
            # ----------------------------------------------------------------
            print("Switching to Values Tab...")
            page.click("button:has-text('Conduct / Values Grading')")

            # Wait for visibility
            expect(page.get_by_text("Maka-Diyos")).to_be_visible()

            # Check Dropdowns
            # Verify we can see the select elements
            selects = page.locator("select")
            expect(selects.first).to_be_visible()

            # ----------------------------------------------------------------
            # 4. Test Release Button
            # ----------------------------------------------------------------
            print("Testing Release Button...")
            page.click("button:has-text('Release Report Cards')")

            # Check Flash Message
            expect(page.get_by_text("Report Cards have been successfully released")).to_be_visible()

            # Screenshot success
            page.screenshot(path="verification/part_i_success.png")
            print("Advisory Board verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_i.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_i()
