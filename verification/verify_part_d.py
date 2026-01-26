from playwright.sync_api import sync_playwright, expect

def test_part_d():
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
            # 1. Test Parent Billing Details
            # ----------------------------------------------------------------
            print("Testing Parent Billing Details...")
            page.goto("http://127.0.0.1:8000/parent/billing")

            expect(page.locator("header").get_by_text("Billing Details")).to_be_visible()
            expect(page.get_by_text("Statement of Account History")).to_be_visible()
            expect(page.get_by_text("Total Outstanding Balance")).to_be_visible()
            # Check mock data
            expect(page.get_by_text("6,000.00")).to_be_visible()
            expect(page.get_by_text("Bill Breakdown")).to_be_visible()
            expect(page.get_by_text("Tuition Fee (Sep)")).to_be_visible()
            expect(page.get_by_text("Transaction History")).to_be_visible()
            expect(page.get_by_text("OR-2023-001")).to_be_visible()

            print("Parent Billing Details verified.")

            # ----------------------------------------------------------------
            # 2. Test Finance Expense Manager
            # ----------------------------------------------------------------
            print("Testing Finance Expense Manager...")
            page.goto("http://127.0.0.1:8000/finance/expenses")

            expect(page.locator("header").get_by_text("Expense Manager")).to_be_visible()
            expect(page.get_by_text("Expense Tracking")).to_be_visible()

            # Check Table
            expect(page.get_by_text("Meralco Bill (Jan)")).to_be_visible()
            expect(page.get_by_text("15,000.00")).to_be_visible()

            # Check Modal
            print("Testing Expense Modal...")
            page.click("button:has-text('Log New Expense')")
            # Scope to header to avoid ambiguity with button
            expect(page.locator("h3:has-text('Log New Expense')")).to_be_visible()

            # Fill Form
            page.fill("input#date", "2023-02-01")
            page.select_option("select#category", "Supplies")
            page.fill("input#description", "Bond Paper")
            page.fill("input#amount", "500")

            # Save
            page.click("button:has-text('Log Expense')")

            # Verify new entry
            expect(page.get_by_text("Expense logged successfully.")).to_be_visible()
            expect(page.get_by_text("Bond Paper")).to_be_visible()
            # Use exact match or regex anchor to avoid matching "3,500.00" when looking for "500.00"
            expect(page.get_by_text("500.00", exact=True)).to_be_visible()

            print("Finance Expense Manager verified.")

            print("All Part D Features Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_part_d.png")
            print("Captured error_part_d.png")
            raise e

        finally:
            browser.close()

if __name__ == "__main__":
    test_part_d()
