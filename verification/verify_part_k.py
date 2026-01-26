from playwright.sync_api import sync_playwright, expect
import re

def test_part_k():
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
            # 1. Test Promotion Page Load
            # ----------------------------------------------------------------
            print("Testing Batch Promotion Page...")
            page.goto("http://127.0.0.1:8000/registrar/promotion")

            # Check Header
            expect(page.get_by_text("Batch Promotion / Retention")).to_be_visible()

            # Check Filter
            expect(page.get_by_text("Current Grade Level")).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Verify Table Logic (Passing vs Failing)
            # ----------------------------------------------------------------
            print("Verifying Table Logic...")

            # Passing Student: Alonzo, Bea (88)
            passing_row = page.locator("tr").filter(has_text="Alonzo, Bea")
            expect(passing_row.locator("text=Promoted")).to_be_visible()
            # Check checkbox is enabled (not disabled)
            expect(passing_row.locator("input[type='checkbox']")).to_be_enabled()

            # Failing Student: Cruz, John (74)
            failing_row = page.locator("tr").filter(has_text="Cruz, John")
            expect(failing_row.locator("text=Retained")).to_be_visible()
            # Check checkbox is disabled
            expect(failing_row.locator("input[type='checkbox']")).to_be_disabled()

            # ----------------------------------------------------------------
            # 3. Test Action Logic
            # ----------------------------------------------------------------
            print("Testing Promotion Action...")

            # Select passing students
            passing_row.locator("input[type='checkbox']").check()

            # Check Count Update and Wait for State Sync
            # Livewire requests take time. We need to wait for the button to be enabled.
            # The button has `disabled` if count == 0.
            # We wait for the button to NOT have the disabled attribute/state.
            submit_btn = page.locator("button:has-text('Mark as Eligible')")
            expect(submit_btn).to_be_enabled()

            # Click Mark as Eligible
            submit_btn.click()

            # Check Success Flash
            expect(page.get_by_text("Success! 1 students marked eligible")).to_be_visible()

            # Screenshot success
            page.screenshot(path="verification/part_k_success.png")
            print("Batch Promotion verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_k.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_k()
