#!/usr/bin/env python3

import argparse

version = '1.0.0'
parser = argparse.ArgumentParser(description='''TGUI CIDR Resolver. Developed by Aleksey Mochalin''')
parser.add_argument('-v', '--version', action='version',
                    version='TGUI Network Manager {version}'.format(version=version), help='show current version')

parser.add_argument('-v6','--ipv6', action='store_true',
                    help='set ipv6 type, default ipv4')
parser.add_argument('-net','--network', metavar='[network]',
                    help='set network parameter')
parser.add_argument('-addr','--address', metavar='[address]',
                    help='set address parameter')

args = parser.parse_args()

if not args.network or not args.address:
    print(0)
    quit();

from ipaddress import IPv4Network, IPv4Address, IPv6Network, IPv6Address

if args.ipv6:
    try:
        network = IPv6Network(str(args.network))
        address = IPv6Address(str(args.address))
        if IPv6Address(args.address) in IPv6Network(args.network):
            print(1)
            quit()
    except Exception as e:
        print(0)
        quit()
else:
    try:
        network = IPv4Network(args.network)
        address = IPv4Address(args.address)
        if IPv4Address(args.address) in IPv4Network(args.network):
            print(1)
            quit()
    except Exception as e:
        print(0)
        quit()

print(0)
quit()
# print(IPv4Address(args.address) in IPv4Network(args.network))
# print(address)
# print(network)
#
# print(args)
