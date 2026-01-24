from playwright.sync_api import sync_playwright, expect

def test_dashboards():
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
            page.wait_for_url("**/dashboard") # Will likely redirect to default or stay if SchoolYearManager is at /dashboard
            print("Logged in.")

            # ----------------------------------------------------------------
            # 1. Test Super Admin Dashboard
            # ----------------------------------------------------------------
            print("Testing Super Admin Dashboard...")
            page.goto("http://127.0.0.1:8000/dashboards/super-admin")

            expect(page.locator("header").get_by_text("System Monitor")).to_be_visible()
            expect(page.get_by_text("Active School Year")).to_be_visible()
            expect(page.get_by_text("2025-2026")).to_be_visible()
            expect(page.get_by_text("Total Users")).to_be_visible()
            expect(page.get_by_text("152")).to_be_visible()
            expect(page.get_by_text("System Status")).to_be_visible()
            expect(page.get_by_text("Healthy")).to_be_visible()

            print("Super Admin Dashboard verified.")

            # ----------------------------------------------------------------
            # 2. Test Admin Dashboard
            # ----------------------------------------------------------------
            print("Testing Admin Dashboard...")
            page.goto("http://127.0.0.1:8000/dashboards/admin")

            expect(page.locator("header").get_by_text("DSS & Analytics")).to_be_visible()
            expect(page.get_by_text("Enrollment Forecast")).to_be_visible()
            expect(page.get_by_text("520")).to_be_visible() # Forecast
            expect(page.get_by_text("+15% Growth")).to_be_visible()
            expect(page.get_by_text("Financial Health Overview")).to_be_visible()
            # Check for mocked amounts (number_format might add commas)
            expect(page.get_by_text("1,500,000")).to_be_visible()
            expect(page.get_by_text("1,200,000")).to_be_visible()

            print("Admin Dashboard verified.")

            # ----------------------------------------------------------------
            # 3. Test Registrar Dashboard
            # ----------------------------------------------------------------
            print("Testing Registrar Dashboard...")
            page.goto("http://127.0.0.1:8000/dashboards/registrar")

            expect(page.locator("header").get_by_text("Population Analytics")).to_be_visible()
            expect(page.get_by_text("Population Density")).to_be_visible()
            # Use exact to avoid matching the Capacity Alert text
            expect(page.get_by_text("Grade 7", exact=True)).to_be_visible()
            expect(page.get_by_text("120 Students")).to_be_visible()
            expect(page.get_by_text("Capacity Alert")).to_be_visible()
            expect(page.get_by_text("Grade 7 - Rizal (98% Full)")).to_be_visible()

            print("Registrar Dashboard verified.")

            print("All Dashboards Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_dashboards.png")
            print("Captured error_dashboards.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_dashboards()
