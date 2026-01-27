from playwright.sync_api import sync_playwright, expect
import time

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context()
        page = context.new_page()

        try:
            # 1. Login
            print("Navigating to login...")
            page.goto("http://localhost:8001/login")
            page.fill("input[name='email']", "test@example.com")
            page.fill("input[name='password']", "password")
            print("Logging in...")
            page.click("button[type='submit']")

            # Wait for dashboard or redirection
            page.wait_for_url("**/dashboard")
            print("Logged in.")

            # 2. Go to DepEd Reports
            print("Navigating to DepEd Reports...")
            page.goto("http://localhost:8001/admin/reports/deped")

            # Verify Header
            print("Verifying header...")
            expect(page.get_by_role("heading", name="DepEd Reports Dashboard")).to_be_visible()

            # 3. Test SF1 Generation
            print("Testing SF1 Generation...")

            # Locate Card 1
            card1 = page.locator("div.bg-white").filter(has_text="School Form 1 (SF1)")

            # Select Grade 10
            card1.locator("select").nth(0).select_option("10") # Grade
            card1.locator("select").nth(1).select_option("B")  # Section

            # Click Generate
            print("Clicking Generate SF1...")
            with page.expect_navigation():
                card1.get_by_role("button", name="Generate SF1").click()

            # 4. Verify Preview
            print("Verifying Preview...")

            # Loose check for URL params
            assert "type=SF1" in page.url
            assert "grade=10" in page.url
            assert "section=B" in page.url

            expect(page.get_by_text("Official Report Preview: School Form 1")).to_be_visible()
            # Use exact=True to avoid strict mode error
            expect(page.get_by_text("Grade 10 - Section B", exact=True)).to_be_visible()

            # 5. Screenshot
            print("Taking screenshot...")
            page.screenshot(path="verification/verification.png")

            print("Verification successful!")

        except Exception as e:
            print(f"Verification failed: {e}")
            page.screenshot(path="verification/error.png")
            raise e
        finally:
            browser.close()

if __name__ == "__main__":
    run()
