/**
 * @file
 * Defines Javascript behaviors for the interesting module.
 */

(function ($) {

  'use strict';

  /**
   * Get te long and lat from an address.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Get the long and lat.
   */
  Drupal.behaviors.getLotLang = {
    attach: function (context) {
      var $context = $(context);

      $context.find('#edit-search').click(function(event) {
        event.preventDefault();

        var address = "http://maps.googleapis.com/maps/api/geocode/json?address=" + $('#edit-location').val() + "'&sensor=false";

        console.log(address);

        $.ajax(address)
          .done(function(data) {
            if (data.status != 'OK') {
              // throw not found error.
              return;
            }

            var location = data.results[0].geometry.location;

            $('#edit-location-lat').val(location.lat);
            $('#edit-location-lon').val(location.lng);
          });
      });
    }
  };

})(jQuery);
