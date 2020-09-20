function form(title, timed, hour, date) {
  this.title = title;
  //  this.description = arguments.description;
  //  this.public = public;
  //  this.formId = formId;

  this.timed = timed;
  this.hour = hour;
  this.date = date;

  this.blocks = [];

  var addTextQuestion = function (type, question, correct, incorrect) {
    var newBlock = new textQuestion(question, correct, incorrect);
    this.block.append(newBlock);
  };

  var plotForm = function () {
    for (block_id in this.blocks) {
      this.blocks[block_id].plot();
    }
  };

  var randomizeId = function () {
    this.blocks.sort(() => Math.random() - 0.5);
  };
}

class block {
  constructor(question, correct, incorrect) {
    this.question = arguments.question;
    this.correct = arguments.correct;
    this.incorrect = arguments.incorrect;
  }

  plot(x) {
    return x;
  }
}

class textQuestion extends block{
  constructor(question, correct, incorrect){
    super(question, correct, incorrect)
  }
}