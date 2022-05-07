document.write('\
\
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding: 1em;">\
  <a class="navbar-brand" href="#">Stock Tracker</a>\
    <div class="collapse navbar-collapse" id="navbarSupportedContent">\
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">\
        <li class="nav-item active">\
          <a class="nav-item nav-link" href="/users.php">Users</a>\
        </li>\
        <li class="nav-item dropdown">\
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                Stock Trades\
            </a>\
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">\
                <a class="dropdown-item" href="/open_stock_trades/open_stock_trades.php">Open Stock Trades</a>\
                <a class="dropdown-item" href="/closed_stock_trades/closed_stock_trades.php">Closed Stock Trades</a>\
                <a class="dropdown-item" href="/user_open_stock_trades/user_open_stock_trades.php">User Open Stock P/L</a>\
                <a class="dropdown-item" href="/user_closed_stock_trades/user_closed_stock_trades.php">User Closed Stock P/L</a>\
            </div>\
        </li>\
        <li class="nav-item dropdown">\
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                Options Trades\
            </a>\
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">\
                <a class="dropdown-item" href="/open_options_trades/open_options_trades.php">Open Options Trades</a>\
                <a class="dropdown-item" href="/closed_options_trades/closed_options_trades.php">Closed Options Trades</a>\
                <a class="dropdown-item" href="/user_open_options_trades/user_open_options_trades.php">User Open Options P/L</a>\
                <a class="dropdown-item" href="/user_closed_options_trades/user_closed_options_trades.php">User Closed Options P/L</a>\
            </div>\
        </li>\
        <li class="nav-item active">\
          <a class="nav-item nav-link" href="/create_open_stock_trade_sp.php">(SP) Create Open Stock Trade</a>\
        </li>\
        <li class="nav-item active">\
          <a class="nav-item nav-link" href="/report.php">(Report) Closed Stock Trades Per User </a>\
        </li>\
      </ul>\
    </div>\
</nav>\
\
')