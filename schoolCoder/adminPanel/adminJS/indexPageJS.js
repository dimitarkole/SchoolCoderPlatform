<script>
  var today = new Date();
  var myDay = "към " + today.getDate() + "/" +( today.getMonth()+1) + "/" + today.getFullYear();
  var count=0;
  window.onload = function() {
  //  document.cookie = "userSenderName="+ userSenderName;

    var chart = new CanvasJS.Chart("userInSystem", {
      animationEnabled: true,
      title: {
        text: "Потребители в системата"
      },
      subtitles: [{
        text:myDay
      }],
      data: [{
        type: "pie",
        yValueFormatString: "#0",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($userInSystem, JSON_NUMERIC_CHECK); ?>
      }]
    });
    try {
        chart.render();
    } catch (e) {
    }


    var chart = new CanvasJS.Chart("bestStudent", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Петимата ученика"
      },
      subtitles: [{
        text:"с най-висок ранг "+ myDay
      }],
      axisY: {
        title: "Ранг"
      },
      data: [{
        type: "column",
        yValueFormatString: "#,##0.## ранг",
        dataPoints: <?php echo json_encode($bestStudent, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();

    var chart = new CanvasJS.Chart("worseStudent", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Петимата ученика"
      },
      subtitles: [{
        text:"с най-нисък ранг "+ myDay
      }],
      axisY: {
        title: "Ранг"
      },
      data: [{
        type: "column",
        yValueFormatString: "#,##0.## ранг",
        dataPoints: <?php echo json_encode($worseStudent, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();

    var chart = new CanvasJS.Chart("bestTeacher", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Петимата учители"
      },
      subtitles: [{
        text:"с най-висок ранг "+ myDay
      }],
      axisY: {
        title: "Ранг"
      },
      data: [{
        type: "column",
        yValueFormatString: "#,##0.## ранг",
        dataPoints: <?php echo json_encode($bestTeacher, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();

    var chart = new CanvasJS.Chart("worseTeacher", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Петимата учители"
      },
      subtitles: [{
        text:"с най-нисък ранг "+ myDay
      }],
      axisY: {
        title: "Ранг"
      },
      data: [{
        type: "column",
        yValueFormatString: "#,##0.## ранг",
        dataPoints: <?php echo json_encode($bestTeacher, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();
  }

</script>
