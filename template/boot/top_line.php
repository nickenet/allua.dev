      <ol class="breadcrumb">
          <?php

          $fastquotes = array ('<font color="#FFFFFF">', '</font>', '<u>', '</u>');
          $incomingline=str_replace($fastquotes,'',$incomingline);
          $incomingline=str_replace('|','</li><li>',$incomingline);

          ?>

         <li><?php echo $incomingline; ?></li>
      </ol>
