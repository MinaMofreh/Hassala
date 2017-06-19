
<?php
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['str'])) {
    session_start();
    $str = explode('&&', $_POST['str']);
    $student = new Student();
    $QUIZ = new Quiz();
    $id = $str[0];
    $count = $str[1];
    $problem_number = $str[2];
    $number_of_problems = $str[3];
    $CourseName = "$str[4]";
    $QUIZ = $student->TakeQuiz($CourseName);
    $question_number = $id;
    $number_of_questions = $count;
    if ($id < $count) {
        if ($question_number < $number_of_questions) {
            ?>
            <div class="row">
                <div class="col-sm-8">
                    <h5>Question #<?php echo $question_number + 1; ?></h5>
                    <h5><pre><?php echo $QUIZ->questions[$question_number]->question_content; ?></pre></h5>
                </div>
                <div class="col-sm-4">
                    <h5>Grade : <?php echo $QUIZ->questions[$question_number]->question_grade; ?> Marks</h5>
                </div>
            </div>
            <input type="hidden" id="question-id" value="<?php echo $QUIZ->questions[$question_number]->question_id; ?>">
            <?php
            $answers_count = count($QUIZ->questions[$question_number]->answers);
            ?>
            <div class="input-group">
                <?php for ($i = 0; $i < $answers_count; $i++) { ?>
                    <label class="radio-inline">
                        <input type="radio" id="choose" name="optradio" value="<?php echo $QUIZ->questions[$question_number]->answers[$i]->answer; ?>" 
                        <?php
                        if ($_SESSION['student-question-answer'][$question_number]->student_answer != null && $_SESSION['student-question-answer'][$question_number]->student_answer == $QUIZ->questions[$question_number]->answers[$i]->answer) {
                            echo "checked='checked'";
                        }
                        ?>>
                               <?php
                               if ($QUIZ->questions[$question_number]->answers[$i]->answer != null) {
                                   echo $QUIZ->questions[$question_number]->answers[$i]->answer;
                               }
                               ?>
                    </label><br>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    } elseif ($number_of_problems != 0) {
        session_start();
        //Problem Info
        ?> 
        <div class ="row">
            <div class="col-sm-8">
                <h5>Problem #<?php echo $problem_number + 1; ?></h5>
                <strong>
                    <pre><?php echo $QUIZ->problems[$problem_number]->Description; ?></pre>
                </strong>
            </div>
            <div class="col-sm-4">
                <h5>Grade : <?php echo $QUIZ->problems[$problem_number]->grade; ?> Marks</h5>
            </div>
        </div>
        <div class="form-group">
            <label for="input-format">Input format:</label>
            <p id="input-format"><?php echo $QUIZ->problems[$problem_number]->input_format; ?></p>
            <label for="input-format">Output format:</label>
            <p id="input-format"><?php echo $QUIZ->problems[$problem_number]->output_format; ?></p>
        </div>
        <?php
        // Input & Output Examples
        $testCasesCount = count($QUIZ->problems[$problem_number]->test_case);
        for ($x = 0; $x < $testCasesCount; $x++) {
            echo '<label for="exampleInput">Example Input:</label>
                            <pre id="exampleInput">' . $QUIZ->problems[$problem_number]->test_case[$x]->input . '</pre>
                                <label for="exampleOutput">Example Output:</label>
                            <pre id="exampleOutput">' . $QUIZ->problems[$problem_number]->test_case[$x]->output . '</pre>';
            if ($testCasesCount > 1) {
                echo '<hr>';
            }
        }
        ?>
        <label for="select-coding-language">Coding Language:</label>
        <select class="selectpicker" id="select-coding-language">
            <option>GNU GCC</option>
            <option>GNU G++</option>
        </select>
        <!--------------------------------->
        <br>
        <!----Answering problem text area-->
        <label for="exampleTextarea">Please copy your code into the following textarea</label>
        <textarea class="form-control" id="exampleTextarea" rows="30" style="resize:none;font-family: courier new;" name="student_code">
            <?php if ($_SESSION['student-problem-answer'][$problem_number] != null) echo $_SESSION['student-problem-answer'][$problem_number]->student_code; ?>
        </textarea>
        <input type="hidden" id="problem-id" value="<?php echo $QUIZ->problems[$problem_number]->problem_id; ?>">
        <!-- ------------------------------------->
        <?php
    }
    ?> 
    <?php
}
if (isset($_POST['problem_answer']) && isset($_POST['last_p'])) {
    session_start();
    $problem_index = $_POST['last_p'];
    $problem_object = explode(":", $_POST['problem_answer']);
    if ($_SESSION['student-problem-answer'][$problem_index] == null) {
        $problem = new student_quiz_problem();
        $problem->problem_id = $problem_object[0];
        $problem->student_id = $problem_object[1];
        $problem->student_code = $problem_object[2];
        $problem->problem_status = FALSE;
        $_SESSION['student-problem-answer'][] = $problem;
    } else if ($_SESSION['student-question-answer'][$question_index]->student_answer != null) {
        $_SESSION['student-problem-answer'][$problem_index]->student_code = $problem_object[2];
    }
    print_r($_SESSION['student-problem-answer']);
}
if (isset($_POST['question_answer']) && isset($_POST['last_q'])) {
    session_start();
    $question_index = $_POST['last_q'] - 1;
    $question_object = explode(":", $_POST['question_answer']);
    if ($_SESSION['student-question-answer'][$question_index] == null) {
        $question = new student_question();
        $question->student_answer = $question_object[0];
        $question->question_id = $question_object[1];
        $question->student_id = $question_object[2];
        $question->question_status = FALSE;
        $_SESSION['student-question-answer'][] = $question;
    } else if ($_SESSION['student-question-answer'][$question_index]->student_answer != null) {
        $_SESSION['student-question-answer'][$question_index]->student_answer = $question_object[0];
    }
}

if (isset($_POST['solve_data'])) {
    $solve_data = explode('||', $_POST['solve_data']);
    $question_tracker = $solve_data[0];
    $total_number_of_questions = $solve_data[1];
    $total_attempts = $solve_data[2];
    ?> 
    <code>Question <?php echo $question_tracker; ?> of <?php echo $total_number_of_questions ?></code>
    <br>
    <code>Total Attempts : <?php echo $total_attempts; ?></code><br>
    <?php
}