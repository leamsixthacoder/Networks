import { Component, OnInit,Input } from '@angular/core';
import { DataService } from 'src/app/services/data.service';
import {ActivatedRoute} from '@angular/router';
@Component({
  selector: 'app-jobs',
  templateUrl: './jobs.component.html',
  styleUrls: ['./jobs.component.css']
})
export class JobsComponent implements OnInit  {
  @Input() title: string= 'Sin Titulo'
  @Input('categoria') categoria:string = '1'

  
  jobs = [];
  constructor(private dataService:DataService) {
    this.getCategoryData(this.categoria);
  }
  
  ngOnInit(): void {
    this.getCategoryData(this.categoria);

  }

  getCategoryData(id:string){
    this.dataService.getData(id).subscribe(
      (data:any) => {

        this.jobs = data.data;
        console.log(this.jobs)
        
      }
    );
    }

}
