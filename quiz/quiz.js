var questionNumber = 0;

function getQuestions(){
  obj = document.getElementById("question");
  obj.firstChild.nodeValue = "(please wait...)";
  ajaxCallback = nextQuestion;
  ajaxRequest("quiz.xml");
}

function nextQuestion(){
  questions = ajaxreq.responseXML.getElementsByTagName("question");
  obj = document.getElementById("question");
  if(questionNumber < questions.length){
    question = questions[questionNumber].firstChild.nodeValue;
    obj.firstChild.nodeValue = question;
  } else {
    obj.firstChild.nodeValue = "(no more questions...)";
  }
}

function checkAnswer(){
  answers = ajaxreq.responseXML.getElementsByTagName("answer");
  answer = answers[questionNumber].firstChild.nodeValue;
  answerField = document.getElementById("answer");
  if(answer == answerField.value){
    alert("Correct!");
  } else {
    alert("Incorrect! The right answer is " + answer);
  }
  questionNumber++;
  answerField.value = "";
  nextQuestion();
}

obj = document.getElementById("start_quiz");
obj.onclick = getQuestions;
ans = document.getElementById("submit");
ans.onclick = checkAnswer;
