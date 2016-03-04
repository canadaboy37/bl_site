<div class="chart-block">
    <h2>CREDIT LINE</h2>
    <div class="chart-holder">
        <!-- TODO: generate a chart instead of using the image -->
        <img src="images/img02.png" height="444" width="443" alt="image-description">
    </div>
    <ul class="info">
        <li>CREDIT USED: $00,000</li> <!-- TODO: find out which value from the AccountStatus API goes here -->
        <li class="available">AVAILABLE: {{ money_format('%.2n', $creditLimit)  }}</li>
    </ul>
</div>
