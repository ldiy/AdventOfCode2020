lines = open('input.txt', 'r').readlines()

for line1 in lines:
    for line2 in lines:
        if int(line1) + int(line2) == 2020:
            print('res:', int(line1) * int(line2))
            exit()