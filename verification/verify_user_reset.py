
import os
from playwright.sync_api import Page, expect, sync_playwright

def verify_reset_password(page: Page):
    # 1. Login
    page.goto("http://127.0.0.1:8000/login")
    page.fill('input[name="email"]', 'test@example.com')
    page.fill('input[name="password"]', 'password')
    page.click('button:has-text("Log in")')

    # Wait for navigation to dashboard
    page.wait_for_url("**/dashboard")

    # 2. Go to User Manager
    page.goto("http://127.0.0.1:8000/users")

    # 3. Assert Actions Column and Reset Button
    expect(page.get_by_role("columnheader", name="Actions")).to_be_visible()

    # Find the reset button for the first user (John Doe)
    # The view has a loop, so we pick the first row's key button.
    # Button has bx-key icon.
    reset_btn = page.locator("button .bx-key").first
    expect(reset_btn).to_be_visible()

    # 4. Open Modal
    reset_btn.click()

    # 5. Assert Modal Content
    # Title "Reset Password for John Doe"
    expect(page.get_by_text("Reset Password for John Doe")).to_be_visible()

    # Input value
    password_input = page.locator("input[wire\\:model='resetPassword']")
    expect(password_input).to_have_value("marriottconnect2026")

    # 6. Screenshot
    page.screenshot(path="/home/jules/verification/verification.png")

    # 7. Save
    page.click("button:has-text('Save New Password')")

    # 8. Assert Success Message
    expect(page.get_by_text("Success: Password reset to 'marriottconnect2026'")).to_be_visible()

    print("Verification passed!")

if __name__ == "__main__":
    if not os.path.exists("/home/jules/verification"):
        os.makedirs("/home/jules/verification")

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            verify_reset_password(page)
        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="/home/jules/verification/error.png")
            raise e
        finally:
            browser.close()
