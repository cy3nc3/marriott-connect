import os
from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # 1. Login
    # We need a user. Since we are in a dev environment with migrated DB, we can create one using Tinker or just try to register?
    # Or assume a user exists?
    # Let's create a user via Artisan Tinker before running this script to be safe, OR use a factory in a setup script.
    # Actually, simpler: Use 'php artisan tinker' to create a user with known creds.

    page.goto("http://localhost:8000/login")

    # Check if we are already logged in (redirected to dashboard)
    if "login" in page.url:
        page.fill('input[name="email"]', "admin@example.com")
        page.fill('input[name="password"]', "password")
        page.click('button[type="submit"]')

    # Wait for navigation
    page.wait_for_load_state('networkidle')

    # 2. Go to Schedule Builder
    page.goto("http://localhost:8000/admin/schedule")
    page.wait_for_load_state('networkidle')

    # 3. Interact to show different states

    # By default, Section 1 (Grade 7 - Rizal) is selected.
    # It has 'Science 7' (Mrs. Reyes) on Monday 08:00.
    # This should show as "Section Busy" (Blue) or "Subject Match" (Green) if subject selected.

    # Take screenshot of initial state
    page.screenshot(path="verification/schedule_initial.png")

    # Select 'Science 7' as subject to see "Subject Match" (Green)
    page.select_option('select[wire\\:model\\.live="selectedSubject"]', "Science 7")
    page.wait_for_timeout(1000) # Wait for Livewire update
    page.screenshot(path="verification/schedule_subject_match.png")

    # Select 'Mr. Cruz' as teacher overlay to see "Teacher Busy" (Orange)
    # Mr. Cruz is busy Monday 10:00 (teaching Grade 8)
    page.select_option('select[wire\\:model\\.live="selectedTeacher"]', "Mr. Cruz")
    page.wait_for_timeout(1000)
    page.screenshot(path="verification/schedule_teacher_busy.png")

    # 4. Create a Conflict
    # We can't easily create a conflict via UI without clicking "+".
    # But checking the existing "Teacher Busy" (Orange) and "Section Busy" (Blue) and "Subject Match" (Green) covers most requested styles.
    # The "Conflict" (Red) requires Section Busy AND Teacher Busy at same time.
    # Section 1 has Science 7 (Mrs. Reyes) at 8:00.
    # If we select "Mrs. Reyes" as overlay teacher?
    # The logic says:
    # if ($class['teacher'] === $this->selectedTeacher)
    # Mrs. Reyes is teaching THIS section.
    # The "Teacher Busy" logic checks OTHER sections.
    # So selecting Mrs. Reyes won't trigger "Teacher Busy" for her own class in this section.
    # It will trigger "Subject Match" if subject matches.

    # To see Conflict:
    # We need a slot where Section 1 is Busy, AND Selected Teacher is Busy in ANOTHER section.
    # Mock Data:
    # Section 1: Mon 08:00 (Mrs. Reyes)
    # Section 2: Mon 10:00 (Mr. Cruz)
    # If we add a class to Section 1 at Mon 10:00, then Select Mr. Cruz...
    # Let's try to add a class at Mon 10:00.
    # Click the "+" at Mon 10:00 (Monday is index 0 of days? The grid has 'Monday', 'Tuesday'...).

    # Finding the Free slot for Monday 10:00.
    # It's hard to locate by text "+" because there are many.
    # We can try to select 'Mr. Cruz' and verify the orange box appears at 10:00.

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
