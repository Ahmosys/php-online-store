$(document).ready(function () {

    // Create an instance of Notyf : https://github.com/caroso1222/notyf
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'bottom'
        },
        dismissible: true,
    });

    // When the page is loaded
    window.addEventListener("load", function () {
        // If isNotified == 1
        if (localStorage.getItem("addToCartNeedNotif") == 1) {
            // Send notification
            notyf.success("Product succefully added to your cart!");
            // Define isNotified to 0
            localStorage.setItem("addToCartNeedNotif", 0);
        }
        if (localStorage.getItem("deleteFromCartNotif") == 1){
            notyf.error("Product succefully removed from your cart!");
            localStorage.setItem("deleteFromCartNotif", 0);
        }
        if (localStorage.getItem("incrementQuantityFromCartNotif") == 1){
            notyf.success("Succefully added 1 quantity of this product!");
            localStorage.setItem("incrementQuantityFromCartNotif", 0);
        }
        if (localStorage.getItem("decrementQuantityFromCartNotif") == 1){
            notyf.success("Succefully removed 1 quantity of this product!");
            localStorage.setItem("decrementQuantityFromCartNotif", 0);
        }
    });
    
    // Click on "add to cart"
    $(".atc").click(function () {
        // Set local storage item "isNotified" to 1.
        localStorage.setItem("addToCartNeedNotif", 1);
    });
    
    // Click on "delete cart"
    $(".rfc").click(function () {
        localStorage.setItem("deleteFromCartNotif", 1);
    });
    
    // Click on "increment quantity cart"
    $(".iqc").click(function () {
        localStorage.setItem("incrementQuantityFromCartNotif", 1);
    });
    
    // Click on "decrement quantity cart"
    $(".dqc").click(function () {
        localStorage.setItem("decrementQuantityFromCartNotif", 1);
    });

});