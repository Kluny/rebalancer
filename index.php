<!DOCTYPE html>
<body lang="en-CA">
<head>
    <title>Fund Rebalancer</title>

	<?php
		/**
		 * Set locale for formatting currency.
		 */
		setlocale( LC_MONETARY, 'en_US' );

		/**
		 * If the user has selected the number of funds to calculate, create an array of that length. If they haven't submitted any other data, it will be used to initialize the input rows.
		 */
		if ( ! empty( $_GET['funds_count'] ) ) {
			$funds = array_fill( 0, intval( $_GET['funds_count'] ), null );
		}

		/**
		 * If the user has submitted the form...
		 */
		if ( ! empty( $_GET['funds'] ) ) {

			$funds = array();

			/**
			 * Sanitize the input data and process it into an array.
			 */
			foreach ( $_GET['funds'] as $k => $fund ) {
				if ( ! empty( $fund['symbol'] ) ) {
					$funds[ filter_var( $fund['symbol'], FILTER_SANITIZE_STRING ) ] = floatval( $fund['amount'] );
				}
			} //endforeach

			/**
			 * Sanitize input data and initialize variables for arithmetic
			 */
			$liquid_cash = floatval( $_GET['liquid-cash'] );

			$invested_cash = array_sum( $funds );

			$total_cash = $liquid_cash + $invested_cash;

			$n_buckets = count( $funds );

			$contribute = array();

			// Simple math to level the buckets and process values into results array
			foreach ( $funds as $fund_name => $amount_invested ) {
				$contribute[ $fund_name ]   = ( $total_cash / $n_buckets ) - $amount_invested;
				$final_totals[ $fund_name ] = ( $contribute[ $fund_name ] + $amount_invested );
			} //endforeach

		} //endif

	?>

</head>
<body>
<h1>Fund rebalancing tool</h1>

<div class="info">
    <h3>What is Rebalancing?</h3>
    <p>Rebalancing is the process of realigning the weightings of a portfolio of assets. Rebalancing involves
        periodically buying or selling assets in a portfolio to maintain an original desired level of asset allocation.
    </p>
    <p>This tool calculates how much to buy or sell from each bucket of funds based on the current market value and how
        much you have to invest. Select the number of funds to balance to begin.
    </p>
    <p>Then enter the stock symbols of your funds to label them, and their current market value. Enter your contribution
        as "Cash Available". Use the results to decide how much to buy or sell from each fund to keep each fund at an
        equal allocation.</p>
</div>

<form action="#" method="get">
	<?php if ( empty( $funds ) ) : ?>
        <div class="row">
            <div class="col">
                <label for="funds-count">How many funds to rebalance?</label>
                <input id="funds-count" placeholder="eg. 4" name="funds_count" value="4" max="10" type="number" min="1">
                <input type="submit">
            </div>
        </div>
	<?php else: ?>

	<?php foreach ( $funds as $k => $fund ): ?>
        <div class="row">
            <div class="col">
                <label for="symbol-<?php echo $k; ?>">Fund Symbol </label>
                <input id="symbol-<?php echo $k; ?>" placeholder="eg. TDB900"
                       name="funds[<?php echo $k; ?>][symbol]"
                       value="<?php echo htmlentities( filter_var( $k ), FILTER_SANITIZE_STRING ); ?>">
            </div>
            <div class="col">
                <label for="amount-<?php echo $k; ?>">Current Amount </label>
                <input id="amount-<?php echo $k; ?>" type="number" placeholder="$0.00"
                       name="funds[<?php echo $k; ?>][amount]" value="<?php echo htmlentities( floatval( $fund ) ); ?>">
            </div>

        </div>
	<?php endforeach; ?>
    <div class="row">
        <div class="col formfoot">
            <label for="liquid-cash">Cash Available </label>
            <input id="liquid-cash" type="number" placeholder="$0.00" name="liquid-cash"
                   value="<?php echo htmlentities( floatval( $_GET['liquid-cash'] ) ); ?>">
            <input type="submit">
            <span class="reset"><a href="/srs/math">Reset</a> </span>
        </div>
		<?php endif; ?>
        <div class="col formfoot">
			<?php if ( ! empty( $contribute ) ) { ?>
                <label>Contribute:</label>
                <ul class="results">
					<?php foreach ( $contribute as $symbol => $amount ) { ?>
                        <li>
                            <label for="<?php echo filter_var( $symbol . $amount, FILTER_SANITIZE_STRING ); ?>"><?php echo $symbol; ?>
                                : </label>
                            <input id="<?php echo filter_var( $symbol . $amount, FILTER_SANITIZE_STRING ); ?>"" name="" value="<?php echo sprintf( '$ %.2f', floatval( $amount ) ); ?>"/>
                        </li>
					<?php } //endforeach ?>
                </ul>
			<?php } //endif ?>
        </div>
    </div><!-- end row -->
</form>


</body>
<style>
    body {
        font-family: Helvetica, sans-serif;
    }

    .col {
        float: left;
        width: 50%;
        border-top: 2px solid black;
    }

    form {
        max-width: 700px;
        height: auto;
    }

    .formfoot {
        padding-top: 15px;
        padding-bottom: 5px;
        height: 130px;

    }

    .info {
        width: 700px;
    }

    input {
        background-color: aquamarine;
        background-color: rgba(127, 255, 212, .3);
        font-size: 16px;
        border-radius: 10px;
        padding: 10px;
    }

    input, label {
        display: block;
        margin: 10px;
    }

    li {
        list-style: none;
    }

    .results input {
        background-color: white;
        font-size: 13px;
        padding: 5px;
        border-radius: 0;
        display: inline;
    }

    .results label {
        display: inline;
    }

    .reset {
        margin-left: 20px;
        line-height: 30px;
    }

    .row {
        clear: both;
    }
</style>

