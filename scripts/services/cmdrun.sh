#!/bin/bash

unset t_std t_err
eval "$( ( $@ ) \
       2> >(t_err=$(cat); typeset -p t_err) \
         > >(t_std=$(cat); typeset -p t_std) )"
if [ -z "$t_err" ]; then
echo "$t_std";
else
echo "error:"$'\n'"$t_err";
fi
exit 0;
