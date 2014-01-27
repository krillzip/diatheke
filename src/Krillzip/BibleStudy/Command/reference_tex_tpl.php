\documentclass[a4paper,11pt,twoside]{report}
\usepackage[top=15mm,left=20mm,right=52mm,bottom=15mm]{geometry}
\usepackage{multicol}
\usepackage[T1,T2A]{fontenc}
\usepackage[utf8]{inputenc}

\DeclareUnicodeCharacter{00A0}{ }

\title{Ett bibelstudium om\\Helgelse i nya testamentet}
\author{Kristoffer Paulsson}

\makeatletter
 \renewcommand\section{\@startsection {section}{1}{\z@}%
     {-2.5ex \@plus -1ex \@minus -.2ex}%
     {1.3ex \@plus.2ex}%
    {\bfseries\centering}}

\begin{document}
\begin{titlepage}
  \newgeometry{margin=25mm}
  \maketitle
  \newpage
  \thispagestyle{empty}
  \mbox{}
\end{titlepage}

\scriptsize
\raggedright
\setcounter{secnumdepth}{0}

\tableofcontents
\newpage

<?php foreach($texts as $row): ?>
<?php $chapter = 0; ?>
\section[<?php 
    echo $row->book.' '.trim(substr($row->reference, strrpos($row->reference, ' '))); 
    ?>]{\textmd{{\normalsize <?php 
    echo $row->header; 
    ?>}\\{\scriptsize <?php
    echo $row->book.' '.trim(substr($row->reference, strrpos($row->reference, ' '))); 
    ?>}}}
\begin{multicols}{2}
\noindent <?php foreach($row->text as $vNum => $verse): ?>\textsuperscript{<?php
if($verse['chapter'] != $chapter){
    $chapter = $verse['chapter'];
    echo $verse['chapter'].':'.$verse['verse'];
}else{
    echo $verse['verse'];   
}
?>} <?php echo $verse['text']; ?><?php if($vNum < (count($row->text)-1)): ?>\linebreak <?php endif; ?>
<?php endforeach; ?>

\end{multicols}
<?php endforeach; ?>
\end{document}