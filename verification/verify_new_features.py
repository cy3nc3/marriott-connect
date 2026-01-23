from playwright.sync_api import sync_playwright, expect

def test_new_features():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(viewport={"width": 1280, "height": 720})
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

            # --- Finance: Product Inventory ---
            print("Testing Product Inventory...")
            page.goto("http://127.0.0.1:8000/finance/inventory")
            expect(page.get_by_text("Product Inventory")).to_be_visible()

            # Test Add Item
            page.click("button:has-text('Add Item')")
            expect(page.locator("#modal-title")).to_be_visible()

            page.fill("input#name", "New Notebook")
            page.select_option("select#type", "Stationery")
            page.fill("input#price", "25.00")

            # Click Save and Wait for Modal to Close or Item to Appear
            page.click("button:has-text('Save')")

            # Use a more explicit wait or assertion that might handle the transition
            print("Waiting for New Notebook...")
            expect(page.get_by_text("New Notebook")).to_be_visible(timeout=10000)

            # Verify added item
            expect(page.get_by_text("Stationery")).to_be_visible()
            expect(page.get_by_text("25.00")).to_be_visible()
            page.screenshot(path="verification/finance_inventory.png")
            print("Product Inventory Verified.")


            # --- Finance: POS ---
            print("Testing POS...")
            page.goto("http://127.0.0.1:8000/finance/pos")
            expect(page.get_by_text("Point of Sale")).to_be_visible()

            # Test Tab Switching
            page.click("button:has-text('Buy Items')")
            expect(page.get_by_text("Math Textbook 7")).to_be_visible()

            # Add to Cart
            page.click("button:has-text('Math Textbook 7')")
            expect(page.locator("div.flex-1.overflow-y-auto").get_by_text("Math Textbook 7")).to_be_visible()

            # Test Payment
            total = page.get_by_text("Total Due:").locator("xpath=..").inner_text()
            print(f"Total: {total}")

            page.fill("input#cashTendered", "600")
            # Click process payment
            page.click("button:has-text('Process Payment')")

            # Wait for success message or empty cart
            expect(page.get_by_text("Payment processed successfully.")).to_be_visible()

            page.screenshot(path="verification/finance_pos.png")
            print("POS Verified.")


            # --- Registrar: Enrollment Wizard ---
            print("Testing Enrollment Wizard...")
            page.goto("http://127.0.0.1:8000/registrar/enrollment")
            expect(page.get_by_text("Step 1: Identity")).to_be_visible()

            # Step 1
            page.fill("input#studentName", "Student A")
            page.fill("input#lrn", "123456789")
            page.fill("input#parentName", "Parent A")
            page.fill("input#parentEmail", "parent@example.com")
            page.click("button:has-text('Next')")

            # Step 2
            expect(page.get_by_text("Academic Information")).to_be_visible()
            page.select_option("select#gradeLevel", "8")
            page.select_option("select#section", "A")
            page.click("button:has-text('Next')")

            # Step 3
            expect(page.get_by_text("Billing Information")).to_be_visible()
            page.fill("input#downpayment", "5000")
            page.select_option("select#paymentPlan", "Cash")
            page.click("button:has-text('Confirm Enrollment')")

            # Verify Reset (Back to Step 1)
            expect(page.get_by_text("Enrollment Successful")).to_be_visible()
            expect(page.get_by_text("Student & Parent Information")).to_be_visible()
            page.screenshot(path="verification/registrar_enrollment.png")
            print("Enrollment Wizard Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_new_features.png")
            print("Captured error_new_features.png")

        finally:
            browser.close()

if __name__ == "__main__":
    test_new_features()
