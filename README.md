## Git Lapse

Git Lapse helps developers utilize the effects of commits in version control. As a specialized tool, Git Lapse shows progression of code through multiple commits instead of Github's own side-by-side. This is targeted toward focused visualization of version control on a specific file. This project relies on LAMP (Linux, Apache, mySQL, and PHP) to generate unique webpages for each commit and enables the user to see line-by-line changes over numerous commits. Git Lapse also generates a GIF for easy visualization. 

## Motivation

This was made in the Web and Mobile Development Research Lab at Thomas Jefferson High School for Science and Technology as a senior research project. I created this because I was annoyed by Github's solution to see multiple versions of a file and wanted to offer another alternative. Although they offer a "difference between consecutive commit" and "view repository at this commit," seeing multiple commits remains impossible. It's also difficult to find a specific version of a file with various contributors, branches, and commits.Git Lapse resolves this as a one stop solution to see all commit changes and its individual effects on files.

## Installation

###Prerequisites
This project requires LAMP and Composer to be installed.

###Windows Linux
1. Make sure you have LAMP installed through [XAMPP](https://www.apachefriends.org/index.html)
2. Make sure you have [Composer](https://getcomposer.org/) installed.
2. Download this repository using either option
    - Download as a zip
    - Using [Git](https://git-scm.com/downloads),```git clone https://github.com/Jas1052/github_lapse.git```
3. Go to installed LAMP folder and go to **~/opt/htdocs/** and open **index.php** through a text editor. [Sublime](https://www.sublimetext.com/) works well but any text editor will do.
4. Start LAMP control panel
    - Windows: Search LAMP in search
    - Linux: ```sudo ~/lampp/share/xampp-control-panel``` with directory of lamp for ~/

        - Ubuntu: ```sudo /opt/lampp/share/xampp-control-panel/xampp-control-panel```


## Contributors

Made with love by [Jason Liu](www.github.com/Jas1052)
