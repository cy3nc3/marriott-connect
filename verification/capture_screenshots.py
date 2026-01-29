import os
import time
import subprocess
import requests
import re
from playwright.sync_api import sync_playwright

BASE_URL = "http://127.0.0.1:8000"
SCREENSHOT_DIR = "public/screenshots"
APP_LAYOUT_PATH = "resources/views/layouts/app.blade.php"
DASHBOARD_PATH = "resources/views/dashboard.blade.php"

ROLES = [
    'super_admin',
    'admin',
    'registrar',
    'finance',
    'teacher',
    'student',
    'parent'
]

EXTRA_ROUTES = {
    'registrar': [
        ('/registrar/students', 'registrar_students.png')
    ],
    'finance': [
        ('/finance/pos', 'finance_pos.png')
    ],
    'teacher': [
        ('/teacher/grading', 'teacher_grading.png')
    ]
}

def start_server():
    print("Starting server...")
    # Kill any existing server on port 8000
    subprocess.run("fuser -k 8000/tcp", shell=True)

    proc = subprocess.Popen(
        ["php", "artisan", "serve", "--port=8000"],
        stdout=subprocess.DEVNULL,
        stderr=subprocess.DEVNULL
    )
    # Wait for server
    for _ in range(30):
        try:
            requests.get(BASE_URL)
            print("Server is up!")
            return proc
        except:
            time.sleep(1)
    raise Exception("Server failed to start")

def modify_role(role):
    print(f"Modifying role to: {role}")
    # Modify app.blade.php
    with open(APP_LAYOUT_PATH, 'r') as f:
        content = f.read()

    new_content = re.sub(r"\$role\s*=\s*\$role\s*\?\?\s*'super_admin';", f"$role = $role ?? '{role}';", content)

    if new_content == content and role != 'super_admin':
        print(f"Warning: No change made to {APP_LAYOUT_PATH}")

    with open(APP_LAYOUT_PATH, 'w') as f:
        f.write(new_content)

    # Modify dashboard.blade.php
    with open(DASHBOARD_PATH, 'r') as f:
        content = f.read()

    new_content = re.sub(r"\$role\s*=\s*\$role\s*\?\?\s*'super_admin';", f"$role = $role ?? '{role}';", content)

    if new_content == content and role != 'super_admin':
        print(f"Warning: No change made to {DASHBOARD_PATH}")

    with open(DASHBOARD_PATH, 'w') as f:
        f.write(new_content)

def revert_changes():
    subprocess.run(["git", "checkout", APP_LAYOUT_PATH])
    subprocess.run(["git", "checkout", DASHBOARD_PATH])

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
            page.fill("input[name='email']", "admin@marriott.test")
            page.fill("input[name='password']", "password")
            page.click("button:has-text('Log in')")
            page.wait_for_url(f"{BASE_URL}/dashboard")
            print("Logged in successfully.")

            for role in ROLES:
                print(f"--- Processing role: {role} ---")

                # If role is super_admin, we might not need to modify if it is default,
                # but better to follow pattern.
                # Wait, if I revert, it goes back to 'super_admin'.
                # So for 'super_admin', modification does nothing (replaces same with same), which is fine.

                modify_role(role)
                time.sleep(1) # Wait for file save

                # Go to dashboard
                page.goto(f"{BASE_URL}/dashboard")
                page.wait_for_load_state("networkidle")

                path = os.path.join(SCREENSHOT_DIR, f"{role}_dashboard.png")
                page.screenshot(path=path, full_page=True)
                print(f"Saved {path}")

                # Capture Extras
                if role in EXTRA_ROUTES:
                    for route, filename in EXTRA_ROUTES[role]:
                        print(f"Navigating to {route}")
                        page.goto(f"{BASE_URL}{route}")
                        page.wait_for_load_state("networkidle")
                        path = os.path.join(SCREENSHOT_DIR, filename)
                        page.screenshot(path=path, full_page=True)
                        print(f"Saved {path}")

                revert_changes()

            browser.close()

    except Exception as e:
        print(f"Error: {e}")
        import traceback
        traceback.print_exc()
    finally:
        revert_changes()
        if server_proc:
            print("Stopping server...")
            server_proc.terminate()
            server_proc.wait()

if __name__ == "__main__":
    main()
