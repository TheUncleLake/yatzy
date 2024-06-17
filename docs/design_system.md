# Yatzy's Design System

A single-player game where 5 dice are rolled each turn. After each roll, the player chooses which dice to keep, and which to reroll. The player may reroll some or all of the dice up to two times on a turn. The player must put a score or zero into a score box each turn. The game ends when all score boxes are used.

## Appearance

### General

- Fonts: Arial, sans-serif
- Colors: Brown frame, dark green board, white dice with black dots, white table with green text (sometimes red text) and lines

### Dice

Five dice will appear on the dark green board when the player rolls the dice. Each dice will be shown in bird's eye view as a rounded square. The number of black dots on the die when viewed from above indicates the value of the roll. After rolling the dice, clicking on a die on the dark green board puts it into a separate rectangular tray, which indicates which dice the player keeps. The dice that remain in the board will be rerolled if the player chooses to do so.

## Game Components

### Starting a new game

The game starts immediately after this webpage is loaded. The player can restart the game by clicking the "Start Game" button. This resets the scoreboard and all the dice.

### In-game play

This game primarily uses no keyboard but rather clicks. To roll dice, click on the "Roll" button. To select which dice to keep, click on them after rolling them. The "Roll" button will allow for 2 more rerolls until it is grayed out and the player is forced to fill in the scoreboard, by clicking on a precalculated score (as indicated by a red number) in a table entry. After having put a score into a score box, the player can roll dice again and keep playing.

### Scoreboard

The scoreboard has 2 main sections: upper section (each box in which sums all dice showing its respective number) and lower section (one pair, two pairs, three of a kind, four of a kind, small straight, large straight, full house, chance, and yatzy). After having rolled the dice, the precalculated scores shown in red will appear in all unused boxes. Rerolling dice will update these scores accordingly. Clicking on a red score will complete a turn, and the score will turn green as it becomes fixed for the rest of the game.

### End of the game

After the player has filled in all of the score boxes, the game shows the total score as a separate row in the score table. The final score is shown in gold yellow, and all buttons are grayed out so that the player knows the game is over, with the exception of the "Start Game" button if the player wants to start a new game.