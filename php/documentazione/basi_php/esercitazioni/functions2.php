<?php

// Type JUGGLING ---
function myFunc6(string | null $p1): string{
	return 0;
}

//echo myFunc6("test");


function myFunc5(string | null $p1): int{
	return "4";
}

echo myFunc5("test");


// PURE -- tutte le funzioni che TORNANO QUALCOSA
// NON-PURE -- tutte le funzioni che non TORNANO QUALCOSA... le funzioni VOID

