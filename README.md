# dhcpd parser

This package attempts to give the user various ways of retrieving the connected list of clients, by implementing a few
of them out of the box.

These are for now the options that are possible through this package:
- dhcpd main log (through journalctl)
- dhcpd leases database (which complements the information from the journal)
- Through the `ip neighbour show` command (very little information, but quick and easy)
- Parsing some pages that can be accessed on dd-wrt routers (gives only information about connected WiFi clients)

## Permissions

Opening the journal and leases database requires special permissions. The commands that are run are: 

- Journal: `journalctl -u dhcpd --since="24 hours ago"`
- Leases database: `TODO`

You can create a limited user which can sudo these commands. You can do this by doing the following: 

`TODO`

## FAQ

### Why 2 different methods for dhcpd?

dhcpd is the de-facto DHCP daemon for many distros, but the logging does not occur in a straight-forward manner. The
main log (on older distros, through the files located in `/var/log/`) displays some basic information about who has
asked for an ip address, but doesn't have any up-to-date information about who is currently connected. The good thing
about this method is that it includes static clients as well as dynamic ones.

The other way is by parsing the leases file, which does contain current information.

### What about scanning the arp table?

This has been deprecated in favor of `ip neighbour show`, which this package implements.
