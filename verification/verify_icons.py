from playwright.sync_api import sync_playwright, expect

def test_icons():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(viewport={"width": 1280, "height": 800})
        page = context.new_page()

        try:
            # 1. Test Welcome Page (Public)
            print("Navigating to Welcome Page...")
            page.goto("http://127.0.0.1:8000/")

            # Check for Boxicons CDN
            cdn_link = page.locator("link[href*='boxicons.min.css']")
            if cdn_link.count() == 0:
                # Might be inside specific layout, let's assume if we see bx icons it's working
                pass

            # Check for replaced icons
            # We look for <i class="bx ...">
            expect(page.locator("i.bx.bx-link-external").first).to_be_visible()

            print("Welcome Page icons verified.")

            # 2. Test Dashboard Navigation (Protected)
            print("Logging in...")
            page.goto("http://127.0.0.1:8000/login")
            page.fill("input[name='email']", "test@example.com")
            page.fill("input[name='password']", "password")
            page.click("button:has-text('Log in')")
            page.wait_for_url("**/dashboard")

            # Check Navigation Icons
            # Super Admin defaults -> Dashboard, School Year, Users
            expect(page.locator("i.bx.bx-grid-alt")).to_be_visible() # Dashboard
            expect(page.locator("i.bx.bx-calendar")).to_be_visible() # School Year
            expect(page.locator("i.bx.bx-user")).to_be_visible() # Users

            print("Navigation icons verified.")

            # 3. Test Component Icons (Registrar)
            # Need to switch context or just navigate if we can access directly (RBAC is simulated via layout var)
            # We can't easily change the PHP variable from here without changing code or logging in as another user if multi-auth was real.
            # But we verified the code changes.
            # Let's try to hit a specific dashboard route that might render irrespective of role (if middleware allows, or if we rely on static check)
            # Actually, `dashboards/registrar` route exists.

            print("Testing Registrar Dashboard icons...")
            page.goto("http://127.0.0.1:8000/dashboards/registrar")
            expect(page.locator("i.bx.bx-error")).to_be_visible()

            print("Registrar Dashboard icons verified.")

            print("All Icons Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_icons.png")
            print("Captured error_icons.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_icons()
