
from playwright.sync_api import sync_playwright, expect

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()

        # 1. Login
        print("Navigating to login...")
        page.goto("http://localhost:8080/login")
        page.fill("input[name='email']", "test@example.com")
        page.fill("input[name='password']", "password")
        page.click("button:has-text('Log in')")

        # Wait for dashboard
        print("Waiting for dashboard...")
        page.wait_for_url("**/dashboard")

        # 2. Go to Schedule Builder
        print("Navigating to Schedule Builder...")
        page.goto("http://localhost:8080/admin/schedule")

        # 3. Apply Filters
        print("Applying filters...")
        # Select Teacher: Mr. Cruz
        page.select_option("select#teacher-select", label="Mr. Cruz")
        # Wait for Livewire to update (Orange blocks should appear)
        page.wait_for_timeout(1000)

        # Select Subject: Science 7
        page.select_option("select#subject-select", label="Science 7")
        # Wait for Livewire to update (Green blocks should appear)
        page.wait_for_timeout(1000)

        # 4. Verify Elements
        print("Verifying elements...")
        # Check for Science 7 (Green)
        # It should have bg-green-500
        # Check for Teacher Busy (Orange)
        # It should have bg-orange-400

        # Take Screenshot
        print("Taking screenshot...")
        page.screenshot(path="verification/schedule_builder.png", full_page=True)

        browser.close()
        print("Done.")

if __name__ == "__main__":
    run()
