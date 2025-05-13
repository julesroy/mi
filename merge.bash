#!/bin/bash

source_branch="main"

git checkout "$source_branch"
git pull origin "$source_branch"

branches=$(git branch -r | grep -v "$source_branch" | grep -v '\->' | sed 's/origin\///')

for branch in $branches; do
    echo "==============================="
    echo "Merging $source_branch into $branch"
    echo "==============================="

    if ! git show-ref --quiet refs/heads/"$branch"; then
        git checkout -b "$branch" origin/"$branch"
    else
        git checkout "$branch"
        git pull origin "$branch"
    fi

    git merge "$source_branch"

    if [ $? -ne 0 ]; then
        echo "⚠️ Conflit lors du merge dans $branch. Corrige et fais un commit."
        read -p "Appuie sur Entrée après avoir résolu les conflits pour continuer..."
    fi

    git push origin "$branch"
done

git checkout "$source_branch"