from playwright.sync_api import sync_playwright, expect

def test_pos_refactor():
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

            # Navigate to POS
            print("Navigating to POS...")
            page.goto("http://127.0.0.1:8000/finance/pos")
            expect(page.get_by_text("Point of Sale")).to_be_visible()

            # 1. Test Student Search
            print("Testing Student Search...")
            # Type 'Juan' in search
            page.fill("input[placeholder='Search by Name or LRN...']", "Juan")

            # Wait for dropdown and select Juan Cruz
            expect(page.get_by_text("Juan Cruz")).to_be_visible()
            page.click("text=Juan Cruz")

            # Verify Outstanding Balances section header updates
            expect(page.get_by_text("Outstanding Balances - Juan Cruz")).to_be_visible()

            # Verify specific bill exists
            # Scope to the Outstanding Balances table to avoid ambiguity
            balances_section = page.locator("div:has-text('Outstanding Balances') + div")
            expect(balances_section.get_by_text("Aug Tuition")).to_be_visible()
            # Use first just in case, but scoping should help
            expect(balances_section.get_by_text("3,000.00").first).to_be_visible()

            # 2. Test Add Bill to Cart
            print("Adding Bill to Cart...")
            # Click 'Add' next to Aug Tuition
            row = page.locator("tr", has_text="Aug Tuition")
            row.get_by_role("button", name="Add").click()

            # Verify in Cart
            # The cart container is the right column. We can identify it by "Current Cart"
            cart_container = page.locator("div.md\\:col-span-1")
            expect(cart_container).to_contain_text("Aug Tuition (Juan Cruz)")
            expect(cart_container).to_contain_text("3,000.00")

            # 3. Test Add Product to Cart
            print("Adding Product to Cart...")
            page.click("button:has-text('Math Textbook 7')")
            expect(cart_container).to_contain_text("Math Textbook 7")

            # 4. Test Transaction Inputs
            print("Testing Transaction Inputs...")

            # Verify Total
            # 3000 + 550 = 3550
            # Look for the container having "Total Due:" and check the text inside it
            # We target the span "Total Due:" and check its parent
            total_label = page.get_by_text("Total Due:", exact=True)
            total_section = total_label.locator("..")
            expect(total_section).to_contain_text("3,550.00")

            # Fill OR Number
            page.fill("input#orNumber", "OR-12345")

            # Change Payment Mode to GCash (should hide Cash Tendered)
            page.select_option("select#paymentMode", "GCash")
            expect(page.locator("input#cashTendered")).not_to_be_visible()

            # Change back to Cash
            page.select_option("select#paymentMode", "Cash")
            expect(page.locator("input#cashTendered")).to_be_visible()

            # Fill Cash Tendered (Insufficient)
            page.fill("input#cashTendered", "100")
            page.click("button:has-text('Process Payment')")
            expect(page.get_by_text("Insufficient cash.")).to_be_visible()

            # Fill Cash Tendered (Sufficient)
            page.fill("input#cashTendered", "4000")

            # Check Change (4000 - 3550 = 450)
            change_label = page.get_by_text("Change:", exact=True)
            change_section = change_label.locator("..")
            expect(change_section).to_contain_text("450.00")

            # Process
            page.click("button:has-text('Process Payment')")

            # Verify Success
            expect(page.get_by_text("Payment processed successfully.")).to_be_visible()
            expect(page.get_by_text("Cart is empty")).to_be_visible()

            # Verify cart is empty in the UI
            expect(cart_container).to_contain_text("Cart is empty")

            page.screenshot(path="verification/pos_refactor.png")
            print("POS Refactor Verified.")

        except Exception as e:
            print(f"Error: {e}")
            page.screenshot(path="verification/error_pos.png")
            print("Captured error_pos.png")

        finally:
            browser.close()

if __name__ == "__main__":
    test_pos_refactor()
