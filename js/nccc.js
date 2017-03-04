(function() {
  var app = angular.module('nccc', []);

  // present day truth- change content 
  app.controller('PresentDayController', function(){
    this.pages = pages;
    this.selected = 'introduction';

    this.changeContent = function(page) {
      this.selected = page;
    };
  });

  // main nav bar
  app.directive("includeNav", function() {
    return {
      restrict: 'E',
      templateUrl: "nav.html"
    };
  });

  // main footer
  app.directive("includeFooter", function() {
    return {
      restrict: 'E',
      templateUrl: "footer.html"
    };
  });

  // teaching includes
  app.directive("includeFriday", function() {
    return {
      restrict: 'E',
      templateUrl: "friday.html"
    };
  });

  app.directive("includeSunday", function() {
    return {
      restrict: 'E',
      templateUrl: "sunday.html"
    };
  });

  app.directive("includeSoc", function() {
    return {
      restrict: 'E',
      templateUrl: "soc_audio.html"
    };
  });

  // general includes
  app.directive("includeGlobal", function() {
    return {
      restrict: 'E',
      templateUrl: "global-includes.html"
    };
  });

  // content for present day truth
  var pages = [
    { select_id: 'introduction', title: "Introduction" },
    { select_id: 'anchored_in_storms', title: "Anchored in the Storms of Life" },
    { select_id: 'backslidden_heart', title: "The Backslidden Heart" },
    { select_id: 'being_under_blood', title: "Being under the Blood" },
    { select_id: 'bishop_1', title: "Bishop Ministry, Part 1" },
    { select_id: 'bishop_2', title: "Bishop Ministry, Part 2" },
    { select_id: 'call_anguish', title: "A Call To Anguish" },
    { select_id: 'price_disobedience', title: "Costs of Disobedience, Part 1" },
    { select_id: 'price_disobedience_2', title: "Costs of Disobedience, Part 2" },
    { select_id: 'jesus_only', title: "The Fallacy of the 'Jesus Only' Doctrine" },
    { select_id: 'christianity_1', title: "Kingdom of God vs Chrisitianity, Part 1" },
    { select_id: 'christianity_2', title: "Kingdom of God vs Chrisitianity, Part 2" },
    { select_id: 'perish_last_days', title: "Leading of the Spirit" },
    { select_id: 'light_salt_conquerors', title: "Light - Salt - Conquerors" },
    { select_id: 'fasting', title: "Notes on Fasting" },
    { select_id: 'sin_gods_eyes', title: "Seeing Sin Through God's Eyes" },
    { select_id: 'whom_shall_go_1', title: "To Whom Shall We Go, Part 1" },
    { select_id: 'whom_shall_go_2', title: "To Whom Shall We Go, Part 2" },
    { select_id: 'sacrifice_living', title: "The Sacrifice of Living" },
    { select_id: 'halloween', title: "The Darkness of Halloween" },
    { select_id: 'birthdays', title: "The Spirit Behind Birthdays" },
    { select_id: 'spirit_christmas', title: "The Spirit Behind Christmas" },
    { select_id: 'spirit_espanol', title: "Espirito Detras de la Navidad" },
    { select_id: 'easter', title: "The Spirit Behind Easter" },
    { select_id: 'valentines', title: "The Spirit Behind Valentine's Day" },
    { select_id: 'unconditional_love', title: "Unconditional Love" }
  ];

})();
