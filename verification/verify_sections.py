from playwright.sync_api import sync_playwright, expect
import time

def run():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context()
        page = context.new_page()

        # 1. Login
        print("Logging in...")
        page.goto("http://localhost:8000/login")
        page.fill("input[name='email']", "admin@example.com")
        page.fill("input[name='password']", "password")
        page.click("button[type='submit']")

        # Wait for navigation
        page.wait_for_url("**/dashboard")
        print("Logged in successfully.")

        # 2. Navigate to Section Manager
        print("Navigating to Section Manager...")
        page.goto("http://localhost:8000/admin/sections")
        expect(page.get_by_role("heading", name="Section Management")).to_be_visible()

        # 3. Verify Elements
        print("Verifying Top Bar elements...")
        expect(page.get_by_text("Filter by Grade:")).to_be_visible()
        expect(page.get_by_role("button", name="Create Section")).to_be_visible()

        print("Verifying Table Columns...")
        # Taking a screenshot to debug layout
        page.screenshot(path="verification/debug_layout.png")
        # Scope to table to avoid strict mode error with modal label
        table = page.locator("table")
        expect(table.get_by_text("Capacity")).to_be_visible()
        expect(table.get_by_text("Actions")).to_be_visible()

        # 4. Test Create/Modal
        print("Opening Create Modal...")
        page.click("button:has-text('Create Section')")

        # Wait for modal
        expect(page.get_by_role("dialog")).to_be_visible()
        expect(page.get_by_label("Capacity")).to_be_visible()
        expect(page.get_by_label("Section Name")).to_be_visible()

        print("Filling Modal...")
        page.fill("input[id='name']", "Test Section Playwright")
        page.select_option("select[id='grade_level']", "10")
        page.fill("input[id='capacity']", "50")

        # Screenshot Modal
        print("Taking screenshot of Modal...")
        page.screenshot(path="verification/section_modal.png")

        # Save
        page.click("button:has-text('Save')")

        # Verify added section
        print("Verifying new section in table...")
        expect(page.get_by_text("Test Section Playwright")).to_be_visible()
        expect(page.get_by_text("50 Students")).to_be_visible()

        # 5. Test Filter
        print("Testing Filter...")
        page.select_option("select[id='filterGrade']", "7")
        time.sleep(1) # Wait for livewire update

        # Should NOT see the new Grade 10 section
        expect(page.get_by_text("Test Section Playwright")).not_to_be_visible()

        # Should see Grade 7 sections (assuming default data has them)
        table_body = page.locator("tbody")
        expect(table_body.get_by_text("Grade 7").first).to_be_visible()

        # 6. Test Edit
        print("Testing Edit...")
        page.select_option("select[id='filterGrade']", "All")
        time.sleep(1)
        expect(page.get_by_text("Test Section Playwright")).to_be_visible()

        # Find the row with our section and click edit
        # Using a slightly complex selector to find the edit button in the row of "Test Section Playwright"
        # Since I can't easily chain parent selectors in this version without more complex locator logic,
        # I'll just click the last edit button or find by proximity.
        # Let's try to get the row first.
        row = page.get_by_role("row", name="Test Section Playwright")
        row.get_by_role("button").first.click() # Assuming first button is edit

        expect(page.get_by_role("dialog")).to_be_visible()
        expect(page.locator("input[id='name']")).to_have_value("Test Section Playwright")
        expect(page.locator("input[id='capacity']")).to_have_value("50")

        page.fill("input[id='capacity']", "55")
        page.click("button:has-text('Save')")

        expect(page.get_by_text("55 Students")).to_be_visible()

        # Final Screenshot
        print("Taking final screenshot...")
        page.screenshot(path="verification/section_manager_final.png")

        browser.close()
        print("Verification complete.")

if __name__ == "__main__":
    run()
