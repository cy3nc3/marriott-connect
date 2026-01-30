import os
import time
import subprocess
import requests
import re
from playwright.sync_api import sync_playwright

BASE_URL = "http://127.0.0.1:8000"
SCREENSHOT_DIR = "public/screenshots"
os.makedirs(SCREENSHOT_DIR, exist_ok=True)

def start_server():
    print("Starting server...")
    subprocess.run("fuser -k 8000/tcp", shell=True)
    subprocess.run("php artisan config:clear", shell=True)
    proc = subprocess.Popen(
        ["php", "artisan", "serve", "--port=8000"],
        stdout=subprocess.DEVNULL,
        stderr=subprocess.DEVNULL
    )
    for _ in range(30):
        try:
            requests.get(BASE_URL)
            print("Server is up!")
            return proc
        except:
            time.sleep(1)
    raise Exception("Server failed to start")

def main():
    server_proc = None
    try:
        server_proc = start_server()

        with sync_playwright() as p:
            browser = p.chromium.launch()
            context = browser.new_context(viewport={'width': 1280, 'height': 800})
            page = context.new_page()

            # Login
            print("Logging in...")
            page.goto(f"{BASE_URL}/login")
            try:
                page.fill("input[name='email']", "admin@marriott.test", timeout=10000)
                page.fill("input[name='password']", "password")
                page.click("button:has-text('Log in')")
                page.wait_for_url(f"{BASE_URL}/dashboard")
                print("Logged in successfully.")
            except Exception as e:
                print(f"Login failed: {e}")
                page.screenshot(path=os.path.join(SCREENSHOT_DIR, "login_failed.png"))
                print(f"Saved login_failed.png")
                raise e

            # Navigate to School Year Manager
            print("Navigating to School Year Manager...")
            page.goto(f"{BASE_URL}/admin/school-year")
            page.wait_for_load_state("networkidle")

            print(f"Current URL: {page.url}")

            # Verify Header
            # Use first=True to avoid strict mode error if multiple exist
            if page.get_by_text("Academic Calendar Management").first.is_visible():
                print("Header found.")
            else:
                print("ERROR: Header 'Academic Calendar Management' not found.")
                page.screenshot(path=os.path.join(SCREENSHOT_DIR, "header_not_found.png"))
                print(f"Saved header_not_found.png")
                # Print page title
                print(f"Page Title: {page.title()}")

            # Verify Hardcoded Data
            # 2024-2025
            if page.get_by_text("2024-2025").is_visible():
                print("Found 2024-2025.")
            else:
                print("ERROR: 2024-2025 not found.")

            # 2025-2026 (Active)
            row_2026 = page.locator("tr", has_text="2025-2026")
            if row_2026.is_visible():
                print("Found 2025-2026.")
                # Check status
                if row_2026.locator("input[type='radio'][checked]").is_visible():
                     print("2025-2026 is marked active.")
                else:
                     print("ERROR: 2025-2026 is NOT active.")

                # Check quarter dropdown
                if row_2026.locator("select").is_visible():
                     print("Quarter dropdown visible for active year.")
                else:
                     print("ERROR: Quarter dropdown NOT visible.")

            # Verify Create Modal
            print("Testing Create Modal...")
            page.click("button:has-text('Create New School Year')")
            time.sleep(2) # wait for animation
            if page.get_by_label("School Year Label").is_visible():
                print("Create Modal opened.")
                page.click("button:has-text('Cancel')")
            else:
                print("ERROR: Create Modal did not open.")
                page.screenshot(path=os.path.join(SCREENSHOT_DIR, "modal_fail.png"))

            # Take screenshot
            path = os.path.join(SCREENSHOT_DIR, "school_year_manager.png")
            page.screenshot(path=path, full_page=True)
            print(f"Saved {path}")

            browser.close()

    except Exception as e:
        print(f"Error: {e}")
        import traceback
        traceback.print_exc()
    finally:
        if server_proc:
            print("Stopping server...")
            server_proc.terminate()
            server_proc.wait()

if __name__ == "__main__":
    main()
