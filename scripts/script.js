/* Author: Imzan Khan
 * Feature: Sorting Game
 * Description: Handles the interactive elements
 *              of the web site, as well interacts
 *              with the Game of Thrones API, and
 *              OAuth 2.0 Google Sign In API.
 * Date Created: April 20th, 2019
 * Last Modified: May 15th, 2019
 * Recent Changes: Fixed Average Time in End Results display
 */

// Clicking the 'Ready?' button initiates the sorting game
$("#start").on("click", function () {
  startGame();
});

$("#tut_start").on("click", function () {
  startTutorial();
  $(".instruction_start").hide();
  $(".tut_question").show();
});


function startTutorial() {
  $(".tut_question").removeClass("correct");
  $("#tut_submit").show();
  $("#tut_start").attr("disabled", true);
  $("#tut_options").sortable();
  $("#tut_options").sortable({
    disabled: false
  });
  let tut_answer = [];
  let tut_answerKey = "Arya Stark,Daenerys Targaryen,Jon Snow,Sansa Stark,Tyrion Lannister";

  $("#tut_options").sortable({
    update: function (event, ui) {
      $(".instruction_submit").show();
      tut_answer.length = 0;
      $(".tut_option").each(function (i) {
        let test = $(".tut_option")
          .eq(i)
          .html();
        tut_answer.push(test);
      });
      tutStr = tut_answer.toString();
    }
  });

  $("#tut_submit").on("click", function () {
    if (tutStr === tut_answerKey) {
      $("#tut_options").sortable({
        disabled: true
      });
      tutStr = "t";
      $(".tut_question").html("Correct! You're ready to take the throne!")
      $(".tut_question").addClass("correct");
      $("#tut_restart").show();
      $("#tut_submit").hide();
      $(".instruction_submit").hide();
    }
  });
  $("#tut_restart").on("click", function () {
    $("#tut_options").html(`<li class="tut_option list-group-item-dark p-2 my-2">Jon Snow</li>
    <li class="tut_option list-group-item-dark p-2 my-2">Arya Stark</li>
    <li class="tut_option list-group-item-dark p-2 my-2">Sansa Stark</li>
    <li class="tut_option list-group-item-dark p-2 my-2">Daenerys Targaryen</li>
    <li class="tut_option list-group-item-dark p-2 my-2">Tyrion Lannister</li>`);

    $(".tut_question").html("Order the following characters in alphabetical order:")
    $(".tut_question").removeClass("correct");
    $("#tut_restart").hide();
    $("#tut_start").attr("disabled", false);
    $("#tut_options").sortable();
  });
}

// Clicking the 'Play Again?' button starts a new game and
// re-initializes the question and buttons
$("#restart").on("click", function () {
  $(".question").removeClass("correct");
  $(".question").html("Order the following characters in alphabetical order:");
  $("#start").attr("disabled", false);
  $("#restart").hide();
  $("#options").empty();
  $("#options").show();
  $("#start").show();
  $("#restart").html("Next Round");
});


$(".close").on("click", function () {
  $("#results_container").hide();
});

// When the index page loads, the players score associated with their
// Google Sign In email is pulled from the database
// and displayed on the web page
function Player() {
  this.player = $("#email").val();
  this.score = 0;
  this.round = 1;
  this.updateScore = function (newScore) {
    this.score += newScore;
    $("#score").html(player1.score);
  };
  this.updateRound = function () {
    this.round += 1;
    $("#round").html(player1.round);
  };
  this.resetGame = function () {
    this.round = 1;
    this.score = 0;
  };
}
var player1 = new Player();


function updateDisplay() {
  $("#score").html(player1.score);
  $("#round").html(player1.round);
}

// This function is called once the user completes a round aka sorts the
// options correctly. The function disables the Sortable functionality of
// the options, hides the submit button, and updates the users score
function roundOver(score) {
  player1.updateScore(score);
  $("#options").sortable({
    disabled: true
  });
  $("#start").hide();
  $("#submit").hide();
  $("#submit").attr("disabled", true);
  $(".question").html("Correct!");
  $(".question").addClass("correct");
  $("#restart").show();
  if (player1.round === 5) {
    $.ajax({
      url: "./functions/updateScore.php",
      method: "POST",
      data: {
        score: player1.score
      }
    });
    gameOver();
  }
}

function gameOver() {
  $("#options").sortable({
    disabled: true
  });
  $("#options").hide();
  $("#start").hide();
  $("#submit").hide();
  $("#submit").attr("disabled", true);
  $(".question").html("Viewing Game Results");
  $("#restart").html("Start New Game?");
  $("#finalScoreDisplay").html(player1.score);
  $("#averageTimeDisplay").html((30 - (player1.score / player1.round)).toFixed(2) + " secs");
  $("#results_container").show();
  player1.resetGame();
}

// When called the function will initialize the arrays and strings
// used to store the order of the options, as well as create an answer
// key based on the ascending order of the data-order attribute.
function startGame() {
  let testKey = [];
  var testStr = "t";
  var testCompareStr = "tc";

  $(".timer").timer("remove");
  updateDisplay();

  // Enables the options to be sorted
  $("#options").sortable({
    disabled: false
  });
  // Creates 5 new options for the user to sort
  generateOptions();

  $("#restart").hide();
  $("#submit").show();
  $("#submit").attr("disabled", false);
  $("#start").attr("disabled", true);


  // Whenever an option is moved, an order key and answer key are generated,
  // where the order key is the order of the options the user has moved them to
  $("#options").sortable({
    update: function (event, ui) {
      testKey.length = 0;

      // The data-order is equal to the Character ID used to pull that specific
      // characters details from the Game Of Thrones API. The ID's are stored
      // in arrays, both will are initialized with the Order ID's of the
      // generatedOptions function.
      $(".option").each(function (i) {
        let test = $(".option")
          .eq(i)
          .html();

        testKey.push(test);
      });

      // To compare the values of the arrays to see if they match, I convert them
      // to strings first. I create one string to store the user's attempt, and 
      // another to store the solution which is the array of strings sorted in 
      // alphabetical order
      testStr = testKey.toString();
      testCompareStr = testKey.sort().toString();
    }
  });

  //When the user wishes to submit their sorted answers, the order string and answer
  // string are compared, when correct , that round is over, and the strings are
  // initialized to arbitrary values. These values do not matter, they are just used
  // such that when the user starts a new game, the previous rounds answer's are not
  // being compared, which results in the submission of incorrect answers.
  $("#submit").on("click", function () {
    if (testStr === testCompareStr) {
      var score = $(".timer").data("seconds");
      $(".timer").timer("pause");
      testStr = "t";
      testCompareStr = "ta";
      player1.updateRound();
      roundOver(score);
    }
  });

  score = $(".timer").data("seconds");

}
// This function generates a random number from 1 to 41, which is equivalent to the number
// of pages the Game of Thrones API uses to store character information, and each page
// contains 50 characters (max amount).
function generateOptions() {
  var pageRandom = Math.floor(Math.random() * 41) + 1;
  $.ajax({
    url: "https://www.anapioficeandfire.com/api/characters/?page=" +
      pageRandom +
      "&PageSize=50",
    method: "GET",
    dataType: "json",
    // When a subset of 50 characters are retrieved, 5 out of the 50 are pulled randomly
    // and if the same number is generated twice, another random number is generated until
    // there are 5 unique values in the arr array.
    success: function (data) {
      var arr = [];
      while (arr.length < 5) {
        var random = Math.floor(Math.random() * 49) + 1;
        if (arr.indexOf(random) === -1) {
          arr.push(random);
        }
      }
      // Once the numbers are generated, the loop will go through the selected characters
      // name information; however, not all characters have name data, therefore, the
      // character alias is taken instead. The list items are then appended to the options list.
      for (let i = 0; i < arr.length; i++) {
        let answer = "";
        if (data[arr[i]]["name"] === null || data[arr[i]]["name"] === "") {
          answer = `<li class="option list-group-item-dark p-2 my-2">${
            data[arr[i]]["aliases"][0]
          } </li>`;
        } else {
          answer = `<li class="option list-group-item-dark p-2 my-2">${
            data[arr[i]]["name"]
          } </li>`;
        }
        $("#options").append(answer);
      }
      // Start timer after options have been generated
      $(".timer").timer({
        countdown: true,
        duration: "30s"
      });
    },
    error: function (data) {
      console.log("Error Retriving Data");
    }
  });
}