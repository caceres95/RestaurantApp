$(document).ready(function(){

	$("#homapage_list_manager").on("click", function(){
        window.location.replace("homepage_restaurant.php");
    });

	$("#restaurant_reviews_list_manager").on("click", function(){
        window.location.replace("customers_reviews.php");
    });

    $("#promotions_list_manager").on("click", function(){
        window.location.replace("promotions_management.php");
    });

    $("#restaurant_profile_manager").on("click", function(){
        window.location.replace("restaurant_profile.php");
    });
});