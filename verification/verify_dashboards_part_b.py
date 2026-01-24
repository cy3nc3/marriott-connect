from playwright.sync_api import sync_playwright, expect

def test_dashboards_part_b():
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
            # 1. Test Finance Dashboard
            # ----------------------------------------------------------------
            print("Testing Finance Dashboard...")
            page.goto("http://127.0.0.1:8000/dashboards/finance")

            expect(page.locator("header").get_by_text("Revenue Analytics")).to_be_visible()

            # Check Collection Efficiency
            expect(page.get_by_text("Collection Efficiency")).to_be_visible()
            expect(page.get_by_text("78% Collected")).to_be_visible()

            # Check Cash
            expect(page.get_by_text("Cash in Drawer (Today)")).to_be_visible()
            expect(page.get_by_text("15,000.00")).to_be_visible()

            # Check Forecast
            expect(page.get_by_text("Revenue Forecast (Next Month)")).to_be_visible()
            expect(page.get_by_text("450,000")).to_be_visible()

            print("Finance Dashboard verified.")

            # ----------------------------------------------------------------
            # 2. Test Teacher Dashboard
            # ----------------------------------------------------------------
            print("Testing Teacher Dashboard...")
            page.goto("http://127.0.0.1:8000/dashboards/teacher")

            expect(page.locator("header").get_by_text("Academic Overview")).to_be_visible()

            # Check Schedule
            expect(page.get_by_text("My Schedule Today")).to_be_visible()
            expect(page.get_by_text("Math 7 - Rizal (Up Next)")).to_be_visible()

            # Check Action Required
            expect(page.get_by_text("Action Required")).to_be_visible()
            # "You have 3 subjects pending Grade Submission."
            # We can check for partial text or structure
            expect(page.get_by_text("subjects pending Grade Submission")).to_be_visible()
            expect(page.get_by_text("3", exact=True)).to_be_visible()

            print("Teacher Dashboard verified.")

            print("All Part B Dashboards Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_dashboards_b.png")
            print("Captured error_dashboards_b.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_dashboards_part_b()
