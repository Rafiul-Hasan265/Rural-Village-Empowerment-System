<div style="max-width: 400px; margin: 100px auto; padding: 25px; border: 1px solid #28a745; border-radius: 8px; font-family: sans-serif;">
    <h3 style="color: #28a745; margin-top:0;">Rent: <?php echo $item['name']; ?></h3>
    <p>Provider: <strong><?php echo $item['company_name']; ?></strong></p>
    <p>Price: <strong>৳<?php echo $item['rental_price']; ?></strong>/day</p>
    
    <form action="index.php?url=process_rent" method="POST">
        <input type="hidden" name="instrument_id" value="<?php echo $item['id']; ?>">
        
        <label>Pick a Date for Rental:</label><br>
        <input type="date" name="rental_date" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px;">
        
        <button type="submit" style="width: 100%; background: #ff9800; color: white; border: none; padding: 12px; border-radius: 4px; font-weight: bold; cursor: pointer;">
            Submit Rental Request
        </button>
    </form>
    <br>
    <a href="index.php?url=view_cart" style="display:block; text-align:center; color: #666; text-decoration: none;">Cancel</a>
</div>