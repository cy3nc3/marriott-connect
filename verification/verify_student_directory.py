from playwright.sync_api import Page, expect, sync_playwright

def test_student_directory(page: Page):
    # 1. Login
    page.goto("http://127.0.0.1:8000/login")
    page.fill('input[name="email"]', 'test@example.com')
    page.fill('input[name="password"]', 'password')
    page.click('button:has-text("Log in")')

    # Wait for dashboard
    expect(page).to_have_url("http://127.0.0.1:8000/dashboard")

    # 2. Navigate to Student Directory via Sidebar
    # Click the "Student Directory" link in the sidebar
    page.click('a:has-text("Student Directory")')

    # Check URL
    expect(page).to_have_url("http://127.0.0.1:8000/registrar/students")

    # 3. Check Page Content
    expect(page.locator('h2')).to_have_text("Student Directory")

    # Check Filters exist
    expect(page.locator('input[placeholder="Search by Name or LRN..."]')).to_be_visible()

    # Check Table has students
    # Just check for "Cruz, Juan"
    expect(page.locator('text="Cruz, Juan"')).to_be_visible()

    # 4. Interact with Modal
    # Click "Manage" for the first student (Juan Cruz)
    page.locator('button:has-text("Manage")').first.click()

    # Check Modal Title
    expect(page.locator('h3#modal-title')).to_contain_text("Documents for Cruz, Juan")

    # Toggle off PSA (it is checked by default for Juan)
    psa_row = page.locator('div.flex.items-center.justify-between', has_text="PSA Birth Certificate (Original)")
    psa_row.locator('label').click()

    # 5. Save
    page.click('button:has-text("Save Updates")')

    # Check Flash Message
    expect(page.locator('text="Requirements updated successfully."')).to_be_visible()

    # 6. Screenshot
    page.screenshot(path="verification/student_directory_verified.png")

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            test_student_directory(page)
        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error.png")
            raise e
        finally:
            browser.close()
