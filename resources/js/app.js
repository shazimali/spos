import ReactDOM from "react-dom";
import React from "react";
import CreatePurchase from "./components/Purchase/CreatePurchase";
import EditPurchase from "./components/Purchase/EditPurchase";
import ReturnPurchase from "./components/Purchase/ReturnPurchase";
import CreateSale from "./components/Sale/CreateSale";
import EditSale from "./components/Sale/EditSale";
import EditReturnPurchase from "./components/Purchase/EditReturnPurchase";
import ReturnSale from "./components/Sale/ReturnSale";
import EditReturnSale from "./components/Sale/EditReturnSale";
import CustomerProfitLoss from "./components/customer-profit-loss/index";
import CustomerLedger from "./components/customer_ledger/index";
import SupplierLedger from "./components/supplier_ledger/index";
import ProductLedger from "./components/product_ledger/index";
import DayBook from "./components/day-book/index";
import ProductProfitLoss from "./components/product-profit-loss/index";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

// require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





if (window.location.href === location.origin+'/purchase-create'){

    if (document.getElementById('create-purchase')) {

        ReactDOM.render(<CreatePurchase />, document.getElementById('create-purchase'));

    }

}


    if (document.getElementById('edit-purchase')) {

        ReactDOM.render(<EditPurchase />, document.getElementById('edit-purchase'));

    }

    if (document.getElementById('return-purchase')) {

        ReactDOM.render(<ReturnPurchase />, document.getElementById('return-purchase'));

    }

    if (document.getElementById('edit-return-purchase')) {

        ReactDOM.render(<EditReturnPurchase />, document.getElementById('edit-return-purchase'));

    }


if (window.location.href === location.origin+'/sales-create'){

    if (document.getElementById('create-sale')) {

        ReactDOM.render(<CreateSale />, document.getElementById('create-sale'));

    }

}

    if (document.getElementById('edit-sale')) {

        ReactDOM.render(<EditSale />, document.getElementById('edit-sale'));

    }


    if (document.getElementById('return-sale')) {

        ReactDOM.render(<ReturnSale />, document.getElementById('return-sale'));

    }

    if (document.getElementById('edit-return-sale')) {

        ReactDOM.render(<EditReturnSale />, document.getElementById('edit-return-sale'));

    }

    if (document.getElementById('customer-profit-loss')) {

        ReactDOM.render(<CustomerProfitLoss />, document.getElementById('customer-profit-loss'));

    }

    if (document.getElementById('customer-ledger')) {

        ReactDOM.render(<CustomerLedger />, document.getElementById('customer-ledger'));

    }

    if (document.getElementById('supplier-ledger')) {

        ReactDOM.render(<SupplierLedger />, document.getElementById('supplier-ledger'));

    }

    if (document.getElementById('product-ledger')) {

        ReactDOM.render(<ProductLedger />, document.getElementById('product-ledger'));

    }

    if (document.getElementById('day-book')) {

        ReactDOM.render(<DayBook />, document.getElementById('day-book'));

    }

    if (document.getElementById('product-profit-loss')) {

        ReactDOM.render(<ProductProfitLoss />, document.getElementById('product-profit-loss'));

    }

