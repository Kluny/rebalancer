# Rebalancer

## Calculator for rebalancing a fund portfolio

Rebalancing is the process of realigning the weightings of a portfolio of assets. Rebalancing involves periodically buying or selling assets in a portfolio to maintain an original desired level of asset allocation.

This is a tool I built to scratch an itch. I have a simple portfolio using the [Canadian Couch Potato Assertive profile](https://cdn.canadiancouchpotato.com/wp-content/uploads/2018/01/CCP-Model-Portfolios-TD-e-Series-2017.pdf).

This portfolio contains a mix of 75% equities divided into three equity funds (Canadian, US and International indexes), and 25% bonds in one bond fund (Canadian). So I label my funds TDB 909, TDB 901 etc, which are the stock symbols of the TD e-Series funds, and enter their current market value. Then it calculates how to split up the contribution so each of the four buckets will be exaclty 25% of my portfolio. In a typical month I'll contribute anywhere from $700 to $4000 to the portfolio, and this tool helps me decide where to allocate it to maintain my equity mix.

Future improvements could include an input for allocation percentages, or an option to use the Aggressive or Conservative portfolio mixes. It could also be converted into a REST API pretty easily or an embeddable widget. However, right now it's just customized for personal use.

Blank demo [here](http://rocketships.ca/srs/math/).

Demo with example values [here](http://rocketships.ca/srs/math/?funds%5Btdb900%5D%5Bsymbol%5D=tdb900&funds%5Btdb900%5D%5Bamount%5D=720&funds%5Btdb902%5D%5Bsymbol%5D=tdb902&funds%5Btdb902%5D%5Bamount%5D=2023&funds%5Btdb500%5D%5Bsymbol%5D=tdb500&funds%5Btdb500%5D%5Bamount%5D=1634&funds%5Btdb901%5D%5Bsymbol%5D=tdb901&funds%5Btdb901%5D%5Bamount%5D=25&liquid-cash=4000#).
