from playwright.sync_api import sync_playwright, expect

def test_refactor():
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

            # Test Routes for Refactored Dashboards
            routes = [
                ("http://127.0.0.1:8000/dashboards/super-admin", "System Monitor"),
                ("http://127.0.0.1:8000/dashboards/admin", "DSS & Analytics"),
                ("http://127.0.0.1:8000/dashboards/registrar", "Population Analytics"),
                ("http://127.0.0.1:8000/dashboards/finance", "Revenue Analytics"),
                ("http://127.0.0.1:8000/dashboards/teacher", "Academic Overview"),
                ("http://127.0.0.1:8000/dashboards/student", "My Dashboard"),
                ("http://127.0.0.1:8000/dashboards/parent", "Parent Portal"),
            ]

            for url, header_text in routes:
                print(f"Testing {url}...")
                page.goto(url)
                expect(page.locator("header").get_by_text(header_text)).to_be_visible()
                print(f"Verified {header_text}")

            # Test Main Switcher (Default Super Admin)
            print("Testing Main Switcher /dashboard...")
            page.goto("http://127.0.0.1:8000/dashboard")
            expect(page.locator("header").get_by_text("System Monitor")).to_be_visible()
            # Verify component content loads (e.g., "Active School Year")
            expect(page.get_by_text("Active School Year")).to_be_visible()

            print("All Refactored Dashboards Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_refactor.png")
            print("Captured error_refactor.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_refactor()
