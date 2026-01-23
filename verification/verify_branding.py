from playwright.sync_api import sync_playwright, expect

def test_branding():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(viewport={"width": 1280, "height": 800})
        page = context.new_page()

        try:
            # 1. Test Welcome Page
            print("Navigating to Welcome Page...")
            page.goto("http://127.0.0.1:8000/")

            # Check Title
            title = page.title()
            print(f"Welcome Page Title: {title}")
            assert "MarriottConnect" in title

            # Check Content
            expect(page.get_by_text("Welcome to MarriottConnect")).to_be_visible()

            # 2. Test Login Page (Guest Layout)
            print("Navigating to Login...")
            page.click("text=Log in")

            # Check Title
            title = page.title()
            print(f"Login Page Title: {title}")
            assert "MarriottConnect" in title

            # 3. Test Dashboard (App Layout & Sidebar)
            print("Logging in...")
            page.fill("input[name='email']", "test@example.com")
            page.fill("input[name='password']", "password")
            page.click("button:has-text('Log in')")
            page.wait_for_url("**/dashboard")

            # Check Title
            title = page.title()
            print(f"Dashboard Title: {title}")
            assert "MarriottConnect" in title

            # Check Sidebar
            expect(page.get_by_text("MarriottConnect")).to_be_visible()
            # Ensure "Edu" is gone (optional check, but good for verification)
            # We look for the exact text span in sidebar
            sidebar_header = page.locator("nav").first
            # actually the sidebar header is above the nav.
            # <span class="ml-3 text-xl font-bold text-gray-800 tracking-tight">Marriott<span class="text-indigo-600">Connect</span></span>
            expect(page.locator("span", has_text="MarriottConnect")).to_be_visible()

            print("Branding Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_branding.png")
            print("Captured error_branding.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_branding()
