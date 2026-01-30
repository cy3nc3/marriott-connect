import os
import re
import subprocess
from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Base URL
    base_url = "http://127.0.0.1:8000"

    print("Setting up test user...")
    # Ensure database is ready and user exists
    subprocess.run(["php", "artisan", "migrate", "--force"], capture_output=True)
    subprocess.run([
        "php", "artisan", "tinker", "--execute",
        "try { \\App\\Models\\User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')]); } catch (\\Exception $e) {}"
    ], capture_output=True)

    print("Logging in...")
    try:
        page.goto(f"{base_url}/login")
        # Snapshot just in case
        page.screenshot(path="login_page.png")

        # Try finding by label which is more user-centric
        page.get_by_label("Email").fill("test@example.com")
        page.get_by_label("Password").fill("password")
        page.get_by_role("button", name="Log in").click()
        page.wait_for_url(f"{base_url}/dashboard")
    except Exception as e:
        print(f"Login failed: {e}")
        page.screenshot(path="login_failure.png")
        print("Page content:")
        print(page.content())
        browser.close()
        return

    print("Navigating to User Manager...")
    page.goto(f"{base_url}/users")

    # 3. Verify Default Users
    print("Verifying default users...")
    expect(page.get_by_text("Principal")).to_be_visible()
    expect(page.get_by_text("Mr. Tan")).to_be_visible()
    expect(page.get_by_text("Ms. Reyes")).to_be_visible()

    # 4. Verify Mr. Tan has Enrollment Agent badge
    print("Verifying Mr. Tan permissions...")
    mr_tan_row = page.locator("tr").filter(has_text="Mr. Tan")
    expect(mr_tan_row.get_by_text("Enrollment Agent")).to_be_visible()

    # 5. Edit Ms. Reyes
    print("Editing Ms. Reyes...")
    ms_reyes_row = page.locator("tr").filter(has_text="Ms. Reyes")
    ms_reyes_row.locator("button").first.click()

    # 6. Verify Modal
    print("Verifying Edit Modal...")
    expect(page.get_by_role("heading", name="Edit User")).to_be_visible()
    # Use generic selector for wire:model if needed, or by label
    # The label is "Name"
    expect(page.locator("input[wire\\:model='name']")).to_have_value("Ms. Reyes")

    # 7. Toggle Grant Enrollment Access
    print("Toggling Enrollment Access...")
    # Label: "Grant Enrollment Access"
    toggle = page.locator("input[wire\\:model='grantEnrollmentAccess']")
    toggle.check(force=True)

    # 8. Save
    print("Saving changes...")
    page.click("button:has-text('Save')")

    # Wait for modal to close
    expect(page.get_by_role("heading", name="Edit User")).not_to_be_visible()

    # 9. Verify Ms. Reyes has badge
    print("Verifying Ms. Reyes permissions...")
    expect(ms_reyes_row.get_by_text("Enrollment Agent")).to_be_visible()

    # 10. Create New User
    print("Creating new user...")
    page.click("button:has-text('Create User')")
    expect(page.get_by_role("heading", name="Create New User")).to_be_visible()

    page.fill("input[wire\\:model='name']", "New Guy")
    page.fill("input[wire\\:model='email']", "new@guy.com")
    page.fill("input[wire\\:model='password']", "password123")
    page.select_option("select[wire\\:model='role']", "admin")
    page.locator("input[wire\\:model='grantEnrollmentAccess']").check(force=True)

    page.click("button:has-text('Save')")
    expect(page.get_by_role("heading", name="Create New User")).not_to_be_visible()

    # 13. Verify New Guy
    print("Verifying New Guy...")
    new_guy_row = page.locator("tr").filter(has_text="New Guy")
    expect(new_guy_row).to_be_visible()
    expect(new_guy_row.get_by_text("Enrollment Agent")).to_be_visible()

    # 14. Reload and Verify Persistence
    print("Verifying session persistence...")
    page.reload()
    expect(page.locator("tr").filter(has_text="New Guy")).to_be_visible()
    ms_reyes_row = page.locator("tr").filter(has_text="Ms. Reyes")
    expect(ms_reyes_row.get_by_text("Enrollment Agent")).to_be_visible()

    print("Verification Successful!")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)
