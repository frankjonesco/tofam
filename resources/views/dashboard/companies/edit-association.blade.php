<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Manage associated articles</h1>


    <h5>Select which articles you would like to associate with this company. </h5>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/{{$company->hex}}/associations/update" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="hex" value="{{$company->hex}}">
            
            <h5 class="pt-4">Associate a new article</h5>
            {{-- Select a new category --}}
            <label for="new_article">Select an article</label>
            <select id="newArticle" rel="#" name="new_article" class="form-select mb-3">
                <option value="" selected disabled>Select a new article...</option>
                @foreach($articles as $article)
                    <option value="{{$article->id}}">{{$article->title}}</option>
                @endforeach
            </select>
            @error('new_article')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <div id="articlesList" class="mb-4">
                <h5 class="pt-4">Current associations:</h5>
                @if(empty($existing_associations))
                    <p id="noArticlesMessage">There are no current associations.</p>
                @else
                    @foreach($existing_associations as $existing_association)
                        <div id="article_{{$existing_association->article_id}}" class="d-flex border-bottom">
                            <div class="p-2">
                                <i class="fa fa-newspaper"></i>
                            </div>
                            <div class="p-2 flex-grow-1">
                                {{$existing_association->article->title}}
                            </div>
                            <div class="p-2">
                                <button
                                    type="button"
                                    id="removeArticle_{{$existing_association->article_id}}" 
                                    onclick="hideArticleRow('{{$existing_association->article_id}}')"
                                    class="btn btn-danger btn-sm"
                                >
                                    <i class="fa fa-trash"></i> 
                                    Remove
                                </button>
                                <button
                                    type="button"
                                    id="undoRemoveArticle_{{$existing_association->article_id}}" 
                                    onclick="showArticleRow('{{$existing_association->article_id}}')"
                                    class="btn btn-secondary btn-sm"
                                    style="display: none;"
                                >
                                    <i class="fa fa-undo"></i> 
                                    Undo
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <input id="articlesArray" name="articles_array" type="hidden" class="form-control mb-3" value="{{$existing_association_ids}}">
            
            <input id="deletedArticlesArray" name="deleted_articles_array" type="hidden" class="form-control" value="">

            <button type="submit" class="btn btn-success btn-sm mt-3">
                <i class="fa-regular fa-floppy-disk"></i>
                Save associations
            </button>
        </form>
    </div>           
</x-admin-card>


<script>
    // ADD ARTICLE (Association)
    var newArticle;
    newArticle = document.getElementById('newArticle');
    newArticle.addEventListener('change', function(){
        if(document.getElementById("noArticlesMessage")){
            document.getElementById('noArticlesMessage').style.display="none";
        }
        var newArticleId;
        newArticleId = newArticle.value;
        var name;
        name = newArticle.options[newArticle.selectedIndex].text;
        articleIsInList = false;
        articlesArray = document.getElementById('articlesArray');
        articlesArrayValues = articlesArray.value;
        articlesValuesArray = articlesArray.value.split(',');
        articleIsInList = articlesValuesArray.includes(newArticleId);
        if(articleIsInList){
            // Category is already in the list
            console.log('Already in list');
            document.getElementById('article_' + newArticleId).style.background="#FFF3CD";
        }else{
            console.log('Not in list');
            deletedArticlesArray = document.getElementById('deletedArticlesArray');
            deletedValues = deletedArticlesArray.value;
            deletedValuesArray = deletedValues.split(',');
            articleIsInList = deletedValuesArray.includes(newArticleId);
            if(articleIsInList){
                // Category is in the deleted list
                console.log('Already in delete list');
                showArticleRow(newArticleId, 'preserveDeleteArray');
            }else{
                // Category is not in the list or the deleted list
                console.log('Not in list');
                var articlesList;
                articlesList = document.getElementById('articlesList');
                articlesList.innerHTML += '<div id="article_' + newArticleId + '" class="d-flex border-bottom"><div class="p-2"><i class="fa fa-newspaper"></i></div><div class="p-2 flex-grow-1">' + name + '</div><div class="p-2"><button type="button" id="removeArticle_' + newArticleId + '" onclick="hideArticleRow(' + newArticleId + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove</button><button type="button" id="undoRemoveArticle_' + newArticleId + '" onclick="showArticleRow(' + newArticleId + ')" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i> Undo</button></div></div>';
                // Set values for form field
                articlesArray.value+=newArticleId + ',';
            }
        }        
    });

    // HIDE ROW (Remove article)
    function hideArticleRow(id){
        // Set opacity for row
        var row = document.getElementById('article_' + id);
        row.style.opacity="0.3";

        // Show/hide delete/undo buttons
        var removeArticleButton = document.getElementById('removeArticle_' + id);
        var undoRemoveArticleButton = document.getElementById('undoRemoveArticle_' + id);
        removeArticleButton.style.display="none";
        undoRemoveArticleButton.style.display="inline-block";

        // Get the current list of colors to be deleted
        articlesArray = document.getElementById("articlesArray");
        listIds = articlesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        articlesArray.value = newList;  
        // Set values for form field
        deletedArticlesArray = document.getElementById('deletedArticlesArray');
        deletedArticlesArray.value+=id + ',';
    }
    // SHOW ROW (Undo remove article)
    function showArticleRow(id, preserveDeleteArray){
        // Set opacity for row
        var row = document.getElementById('article_' + id);
        row.style.opacity="1";
        // Show/hide delete/undo buttons
        var removeArticleButton = document.getElementById('removeArticle_' + id);
        var undoRemoveArticleButton = document.getElementById('undoRemoveArticle_' + id);
        undoRemoveArticleButton.style.display="none";
        removeArticleButton.style.display="inline-block";
        // Set values for form field
        articlesArray = document.getElementById('articlesArray');
        articlesArray.value+=id + ',';
        // Get the current list of colors to be deleted
        deletedArticlesArray = document.getElementById("deletedArticlesArray");
        listIds = deletedArticlesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        deletedArticlesArray.value = newList;  
    }



    
</script>