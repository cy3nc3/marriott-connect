from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # 1. Login
    print("Navigating to Login...")
    page.goto("http://localhost:8000/login")
    page.fill("input[wire\\:model='email']", "teacher@marriott.edu")
    page.fill("input[wire\\:model='password']", "password")
    page.click("button[type='submit']")

    print("Waiting for redirection...")
    page.wait_for_url("**/teacher/grading")
    print("Logged in successfully.")

    # 2. Verify Happy Path Defaults
    print("Verifying default filters...")
    expect(page.locator("select[wire\\:model\\.live='grade']")).to_have_value("Grade 7")
    expect(page.locator("select[wire\\:model\\.live='section']")).to_have_value("Rizal")
    expect(page.locator("select[wire\\:model\\.live='subject']")).to_have_value("Math")

    # 3. Verify Table is loaded
    print("Verifying table presence...")
    expect(page.locator("text=Student Name")).to_be_visible()
    expect(page.locator("text=Cruz, Juan")).to_be_visible()

    # 4. Verify Filters (Empty State)
    print("Testing filter switch (Empty State)...")
    page.select_option("select[wire\\:model\\.live='section']", "Bonifacio")
    page.wait_for_timeout(1000) # Wait for Livewire update
    expect(page.locator("text=Select a Class to Start Grading")).to_be_visible()
    expect(page.locator("table")).not_to_be_visible()

    # Switch back
    print("Switching back to Happy Path...")
    page.select_option("select[wire\\:model\\.live='section']", "Rizal")
    page.wait_for_timeout(1000)
    expect(page.locator("table")).to_be_visible()

    # 5. Add Entry
    print("Testing Add Entry...")
    page.click("button:has-text('Add Entry')")
    expect(page.locator("text=Add New Activity")).to_be_visible()

    page.fill("input[wire\\:model='newActivityTitle']", "QA Test 1")
    page.select_option("select[wire\\:model='newActivityType']", "qa")
    page.fill("input[wire\\:model='newActivityMax']", "50")

    page.click("button:has-text('Save Activity')")
    page.wait_for_timeout(1000) # Wait for modal close and refresh

    # Verify new column
    print("Verifying new column...")
    expect(page.locator("text=QA Test 1")).to_be_visible()
    # Check if QA Header exists (it might not have existed before if there were no QA items)
    expect(page.locator("text=Quarterly Assessment (20%)")).to_be_visible()

    # 6. Verify Score Update and Calculation
    # Find the input for Cruz, Juan for the new QA column.
    # It's the last input in the row typically, or we can target by index.
    # Given the mock data: 2 WW, 1 PT. Now 1 QA.
    # Columns order: WWs, PTs, QAs.
    # So QA is the last group.

    # Let's target the grade cell for Juan Cruz.
    # Juan Cruz is row 1.
    # Initial Grade Check
    grade_cell = page.locator("tr:has-text('Cruz, Juan') td").last
    initial_grade_text = grade_cell.text_content().strip()
    print(f"Initial Grade: {initial_grade_text}")

    # Enter score for QA
    # We need to find the specific input. The inputs are dynamic.
    # Let's just assume the last input in the row is the new QA one.
    input_locator = page.locator("tr:has-text('Cruz, Juan') input[type='number']").last
    input_locator.fill("45")
    input_locator.blur() # Trigger wire:model.blur

    page.wait_for_timeout(2000) # Wait for calculation

    new_grade_text = grade_cell.text_content().strip()
    print(f"New Grade: {new_grade_text}")

    assert new_grade_text != initial_grade_text, "Grade should have updated"

    # Take Screenshot
    print("Taking screenshot...")
    page.screenshot(path="verification/grading_sheet.png", full_page=True)

    print("Grading Sheet verification complete!")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)
