<?php
// php mx logo

use Elegance\Core\Terminal;

return new class
{
    function __invoke()
    {
        Terminal::echo("#@@.   ,@@* /@@  %@&       #@@@@@@@. #@@.   ,@@  #@@@@@@\\");
        Terminal::echo("#@@&   @@@*  %@#,@@        #@&   &@. #@@&   @@@  #@&  \&@\\");
        Terminal::echo("#@@@, /@@@*   @@@@,        #@&   ,,  #@@@, /@@@  #@&   &@%");
        Terminal::echo("#@%@@.@&&@*   .@@#     @@  #@&       #@%@@.@&&@  #@&   &@%");
        Terminal::echo("#@%*@@@.&@*   @@@@,   @@@@ #@&       #@%*@@@.&@  #@&   &@%");
        Terminal::echo("#@% @@% &@*  %@%,@@    @@  #@&   &@. #@% @@& &@  #@&   &@%");
        Terminal::echo("#@% *@. &@* *@@  %@%       #@&,,,&@. #@% *@. &@  #@&,,/@@%");
        Terminal::echo("#@%     &@*.@@*   @@/      \@@@@@@@  #@%     &@  #@@@@@&/");
    }
};
