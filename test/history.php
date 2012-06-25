<!DOCTYPE html>
<html>
  <head>
    <title>Whalebone Studios Travel | Butr</title>
    <!--[if !IE 7]>
    <style type="text/css">
      #wrap {display:table;height:100%}
    </style>
    <![endif]-->
    <script src="../js/contrib/jquery-1.7.2.min.js"></script>
    <script src="../js/contrib/jquery-ui-1.8.19.custom.min.js"></script>
    <script src="../js/contrib/jquery.history.js"></script>
    <script src="../js/contrib/jquery.localisation.min.js"></script>
    <script src="../js/contrib/modernizr-latest.js"></script>
    <script src="../js/contrib/uuid.js"></script>
    <script src="../js/contrib/crypto-sha256-hmac.js"></script>
    <script src="../js/cookies.js"></script>
    <link rel="stylesheet" href="../css/contrib/reset.css" />
    <script type="text/javascript">
      $.localise('../js/locales/strings', {
      language: 'en-AU', loadBase: true});
    </script>
  </head>
  <body>

    <p><a href="javascript:user_admin();">User Admin</a></p>
    <p><a href="javascript:user_add();">User Add</a></p>
    <p><a href="javascript:user_view();">User Add</a></p>
    <p><a href="javascript:home();">Home</a></p>
    



    <script type="text/javascript">
      var History = window.History;

      History.Adapter.bind(window,'statechange',function(){
          'use strict';
          // actually do something here.
          alert(JSON.stringify(History.getState()));
      });

      var butrGlobalConfigurations = {};
      butrGlobalConfigurations.company_name = 'Whalebone Studios';
    </script>
    
    
    <script type="text/javascript">

    function user_admin() {
      'use strict';

      var historyState = {};
      historyState.pageUrl = 'user.php';
      historyState.pageAttributes = '';
      historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration;

      History.pushState(historyState, historyState.pageTitle, '?page=' + historyState.pageUrl + historyState.pageAttributes);
    }

    function user_add() {
      'use strict';

      var historyState = {};
      historyState.pageUrl = 'user.php';
      historyState.pageAttributes = 'action=add';
      historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration;

      History.pushState(historyState, historyState.pageTitle, '?page=' + historyState.pageUrl + '&' + historyState.pageAttributes);
    }

    function user_view() {
      'use strict';

      var historyState = {};
      historyState.pageUrl = 'user.php';
      historyState.pageAttributes = 'action=fetch';
      historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration;

      History.pushState(historyState, historyState.pageTitle, '?page=' + historyState.pageUrl + historyState.pageAttributes);
    }

    function home() {
      'use strict';

      var historyState = {};
      historyState.pageUrl = '../index.php';
      historyState.pageAttributes = '';
      historyState.pageTitle = butrGlobalConfigurations.company_name + ' | Butr | '+butr_i18n_UserAdministration;

      History.pushState(historyState, historyState.pageTitle, '?page=' + historyState.pageUrl + historyState.pageAttributes);
    }    
    </script>
    
  </body>
</html>