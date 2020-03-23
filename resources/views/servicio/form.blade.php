<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- cliente -->
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Cli_NomCli" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Cli_NomCli" id="Cli_NomCli"
                    value="{{old('Cli_NomCli', $cliente->Cli_NomCli ?? '')}}" required style="text-transform: uppercase;" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Cli_NumCel" class="requerido">Célular</label>
                <input type="tel" class="form-control" name="Cli_NumCel" id="Cli_NumCel"
                    value="{{old('Cli_NumCel', $cliente->Cli_NumCel ?? '')}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Cli_NumFij">Fijo</label>
                <input type="tel" class="form-control" name="Cli_NumFij" id="Cli_NumFij"
                    value="{{old('Cli_NumFij', $cliente->Cli_NumFij ?? '')}}" />
            </div>
        </div>
    </div>
</div>