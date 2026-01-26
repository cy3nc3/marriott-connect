from playwright.sync_api import sync_playwright, expect

def test_part_f():
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
            # 1. Test Finance Transaction Log
            # ----------------------------------------------------------------
            print("Testing Finance Transaction Log...")
            page.goto("http://127.0.0.1:8000/finance/history")

            expect(page.locator("header").get_by_text("Transaction Log")).to_be_visible()
            expect(page.get_by_text("Payment Transaction Log")).to_be_visible()

            # Check for mock data
            expect(page.get_by_text("OR-2023-1001")).to_be_visible()
            expect(page.get_by_text("Juan Cruz")).to_be_visible()
            expect(page.get_by_text("3,000.00").first).to_be_visible()

            print("Finance Transaction Log verified.")

            # ----------------------------------------------------------------
            # 2. Test Teacher Grading Submission
            # ----------------------------------------------------------------
            print("Testing Teacher Grading Submission...")
            page.goto("http://127.0.0.1:8000/teacher/grading")

            # Check Initial Status
            expect(page.get_by_text("Status: DRAFT")).to_be_visible()

            # Check inputs are editable (not disabled)
            input_box = page.locator("tbody input[type='number']").first
            expect(input_box).not_to_be_disabled()

            # Click Submit to open modal
            page.click("button:has-text('Submit Grades')")

            # Check Modal
            expect(page.get_by_text("Submit Grades?")).to_be_visible()
            expect(page.get_by_text("Grades will be locked")).to_be_visible()

            # Confirm Submit
            page.click("button:has-text('Yes, Submit')")

            # Wait for update
            expect(page.get_by_text("Grades submitted successfully.")).to_be_visible()
            expect(page.get_by_text("Status: SUBMITTED")).to_be_visible()

            # Check inputs are now disabled
            expect(input_box).to_be_disabled()

            # Check button changed to "Locked" - use strict button role to avoid matching flash message text
            expect(page.get_by_role("button", name="Locked")).to_be_visible()

            print("Teacher Grading Submission verified.")

            print("All Part F Features Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_f.png")
            print("Captured error_part_f.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_f()
