use strict;
use warnings;

if ((scalar @ARGV) != 3) {
    print "Usage: program x y density\n";
    exit;
}

my $x = $ARGV[0];
my $y = $ARGV[1];
my $density = $ARGV[2];
my $i = 0;
my $j = 0;

my $output = "$y\n";

while ($i < $y) {
    $j = 0;
    while ($j < $x) {
        if (int(rand($y) * 2) < $density) {
            $output .= "o";
        } else {
            $output .= ".";
        }
        $j++;
    }
    $output .= "\n";
    $i++;
}

open(my $fh, '>', 'test') or die "Could not open file 'test' $!";
print $fh $output;
close($fh);

print "Result saved to file 'test'.\n";
