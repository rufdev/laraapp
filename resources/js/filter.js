
//Vue moment js to show human readable date
import moment from "moment"; //Import Moment

Vue.filter("formatDate", function(date) {

	return moment(date).format('MMMM Do YYYY');

}); 

Vue.filter('upText', function(text){
    if (text){
        return text.toUpperCase();
    }
    return text;

});

Vue.filter('strlimit', function(text){
    return text.substring(0, 300) + "...";
});

Vue.filter('dateFormat', function(datecreated){
    // console.log(datecreated.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }));
    return moment(datecreated).format('MMMM DD YYYY hh:mm A');
});