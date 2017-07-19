#!/usr/bin/php
<?php
	function getDoorCode($passphrase) {
		// Convert the passphrase to lowercase, remove non alphabetic chars and convert string to an array
		$passphrase = str_split(preg_replace("/[^a-z]/", '', strtolower($passphrase)));

		// Initialise the passcode with the first two letters in the passphrase and remove them from the array 
		$passcode = [getAlphabetNumber(array_shift($passphrase)), getAlphabetNumber(array_shift($passphrase))];

		// Iterate over the passphrase until it is empty
		do {
			// First letter is sum of first two letters
			$passcode[0] = array_sum($passcode);

			// If number of first letter is more than 26, adjust accordingly
			if($passcode[0] > 26) {
				$passcode[0] %= 26;
			}

			// Second letter is sum of the current second letter and the next letter in the passphrase which
			// is removed when accessed
			$passcode[1] += getAlphabetNumber(array_shift($passphrase));
			
			// If number of second letter is more than 26, adjust accordingly
			if($passcode[1] > 26) {
				$passcode[1] %= 26;
			}

		} while(!empty($passphrase));
		
		// Converts numbers back to letters when returning
		return getLetterFromNumber($passcode[0]) . getLetterFromNumber($passcode[1]) . PHP_EOL;
	}

	function getNewDoorCode($passphrase) {
		$initialLetters = "ri";
		define("ALPHA", 5);
		define("BETA", 11);

		// Convert the passphrase to lowercase, remove non alphabetic chars and convert string to an array
		$passphrase = str_split(preg_replace("/[^a-z]/", '', strtolower($passphrase)));

		// Initialise the passcode with the initial letters 
		$passcode = [getAlphabetNumber($initialLetters[0]), getAlphabetNumber($initialLetters[1])];

		// Iterate over the passphrase until it is empty
		do {
			// First letter is second letter * ALPHA + first letter
			$passcode[0] += $passcode[1] * ALPHA;
			
			// If number of first letter is more than 26, adjust accordingly
			if($passcode[0] > 26) {
				$passcode[0] %= 26;
			}

			// Second letter is the current letter * BETA + the second letter, removes the first letter
			// of passphrase on access
			$passcode[1] += getAlphabetNumber(array_shift($passphrase)) * BETA;
			
			// If number of second letter is more than 26, adjust accordingly
			if($passcode[1] > 26) {
				$passcode[1] %= 26;
			}

		} while(!empty($passphrase));
		
		// Converts numbers back to letters when returning
		return getLetterFromNumber($passcode[0]) . getLetterFromNumber($passcode[1]) . PHP_EOL;
	}

	function getAlphabetNumber($letter) {
		return ord($letter) - 96; // Converts to ASCII and subtracts 96, a = 97
	}

	function getLetterFromNumber($number) {
		return chr($number + 96); // Converts back to char
	}

	echo("Question 1: The door code is " . getDoorCode("the traveller in the grey riding-coat, who called himself mr. melville, was contemplating the malice of which the gods are capable."));
	echo("Question 2: The door code is " . getNewDoorCode("the traveller in the grey riding-coat, who called himself mr. melville, was contemplating the malice of which the gods are capable."));
?>
