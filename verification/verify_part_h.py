from playwright.sync_api import sync_playwright, expect

def test_part_h():
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
            # 1. Test Schedule Builder Page Load
            # ----------------------------------------------------------------
            print("Testing Schedule Builder...")
            page.goto("http://127.0.0.1:8000/admin/schedule")

            # Check Header
            expect(page.get_by_text("Select Section:")).to_be_visible()

            # Check for existing Mock Data (Math, Mr. Cruz)
            expect(page.get_by_text("Math").first).to_be_visible()
            expect(page.get_by_text("Mr. Cruz").first).to_be_visible()

            # ----------------------------------------------------------------
            # 2. Test Add Schedule Modal
            # ----------------------------------------------------------------
            print("Testing Add Schedule Modal...")
            page.click("button:has-text('Add Class')")

            expect(page.get_by_text("Add Schedule")).to_be_visible()

            # Fill Form
            page.select_option("select[wire\\:model='newSchedule.subject']", "Science")
            page.select_option("select[wire\\:model='newSchedule.teacher']", "Dr. Garcia")

            # Check Tuesday
            page.check("input[value='Tuesday']")

            # Times
            page.fill("input[wire\\:model='newSchedule.time_start']", "13:00")
            page.fill("input[wire\\:model='newSchedule.time_end']", "14:00")
            page.fill("input[wire\\:model='newSchedule.room']", "Lab 2")

            # Submit
            page.click("button:has-text('Add to Schedule')")

            # ----------------------------------------------------------------
            # 3. Verify Added Class
            # ----------------------------------------------------------------
            print("Verifying added class...")
            # Check validation message
            expect(page.get_by_text("Schedule added successfully.")).to_be_visible()

            # Check if Science appears under Tuesday
            # We target the specific card text class to avoid matching the select option
            # Use .last to resolve multiple 'Science' entries (one mock, one new)
            expect(page.locator("span.font-bold.text-indigo-600").get_by_text("Science").last).to_be_visible()
            expect(page.get_by_text("Lab 2")).to_be_visible()

            # Screenshot success
            page.screenshot(path="verification/part_h_success.png")
            print("Schedule Builder verified. Screenshot saved.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_h.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_h()
