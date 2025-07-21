<?php
declare(strict_types=1);

use Application\model\classes\PageClass;

$page = new PageClass();
$page->title = "My Restaurant | Cash Box";

$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
<section class="cash-box">
    <h3><?php echo mb_strtoupper($page->language['cash_box']); ?></h3>
    <?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">       
        <input type="hidden" name="csrf_token" value="<?php if(isset($csrf_token)) echo $csrf_token->csrf_token(); ?>">
        <div>
            <label for="payment_method"><?php echo $page->language['payment_method']; ?></label>
            <select name="payment_method" id="payment_method" required>
                <option value="<?php echo $payment_method ?? ''; ?>"><?php echo !empty($payment_method) ? ucfirst($payment_methods[intval($payment_method - 1)]['payment_method']) : '- ' . ucfirst($page->language['select']) . ' -'; ?></option>
                <?php foreach($payment_methods as $method): ?>
                    <option value="<?php echo $method['payment_method_id']; ?>"><?php echo ucfirst($method['payment_method']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="total"><?php echo $page->language['invoice_total']; ?></label>
            <input type="number" name="total" id="total" size="4" value="<?php echo isset($total) ? $total : 0; ?>" readonly>
        </div>
        <div>
            <label for="cash_amount"><?php echo $page->language['cash_amount']; ?></label>
            <input type="number" name="cash_amount" id="cash_amount" step="0.01" size="4" value="<?php echo isset($cash_amount) ? $cash_amount : 0; ?>" required>
        </div>
        <div>
            <label for="change"><?php echo $page->language['change']; ?></label>
            <input type="number" name="change" id="change" size="4" value="<?php echo isset($change) ? $change : 0; ?>" readonly>
        </div>        
        <button class="button-primary" type="submit"><?php echo ucfirst($page->language['send']); ?></button>
        <a href="/admin/comandas/index" class="button-danger"><?php echo ucfirst($page->language['cancel']); ?></a>
        <a href="/admin/cashBox/finishOrder/<?php echo $order_id; ?>" class="button-success"><?php echo ucfirst($page->language['to_finish']); ?></a>
    </form>
</section>

<?php
$page->do_html_footer();
?>
